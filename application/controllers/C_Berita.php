<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Berita extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('date');
      $this->load->helper('file');
      $this->load->helper('url');
      $this->load->database('default');
      $this->load->model('M_Berita');
   }

   public function index()
   {
      $data['title'] = "Data Redaksi - Berita";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('berita/V_Berita', $data);
      $this->load->view('berita/layout/berita-js', $data);
      $this->load->view('templates/footer', $data);
   }

   public function view_data_where()
   {
      $tables = 'tb_berita';
      $cari = array('id_berita', 'judul', 'active', 'tgl_upload');
      $where = array('tgl_upload >' => '2022-01-01'); // Jika ada kondisi khusus, tambahkan di sini
      $iswhere = null; // Jika ada kondisi khusus dengan where yang lebih kompleks, tambahkan di sini
      $data = $this->M_Berita->get_tables_where($tables, $cari, $where, $iswhere);
      echo $data;
   }

   function ajax_getbyhdrid()
   {
      $common = 'id_berita';
      $key = $this->input->get('id_berita');
      $data = $this->M_Berita->ajax_getbyhdrid($common, $key, 'tb_berita')->row();
      echo json_encode($data);
   }

   public function ajax_add()
   {
      $mdate = "ID" . mdate('%H%m', time());
      $key = 'id_berita';
      $id_berita2 = $this->M_Berita->Max_data($mdate, $key, 'tb_berita')->row();
      if ($id_berita2->id_berita == NULL) {
         $id_berita = $mdate . "001";
      } else {
         $id_berita = $id_berita2->id_berita;
         $id_berita = "ID" . (intval(substr($id_berita, 3, 11)) + 1);
      }
      $post_data2 = array('id_berita' => $id_berita);
      // Upload foto
      $foto = isset($_FILES['foto']) ? $_FILES['foto']['name'] : null;
      if (!empty($foto)) {
         $upload_result = $this->upload_file_sketch('foto', $id_berita, 'tb_berita');
         if ($upload_result['status']) {
            $post_data2['foto'] = $upload_result['file_name'];
         } else {
            $post_data2['foto'] = null;
         }
      } else {
         $post_data2['foto'] = null;
      }
      // Collect all data post
      $post_data = $this->input->post();
      $post_datamerge = array_merge($post_data, $post_data2);
      $this->M_Berita->Input_Data($post_datamerge, 'tb_berita');
      $data['status'] = 'Success';
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }

   public function ajax_update()
   {
      $id_berita = $this->input->post('id_berita');
      // Dapatkan nama file lama dari database
      $berita = $this->M_Berita->get_by_id($id_berita);
      $old_photo = $berita->foto;

      $new_photo = $old_photo;

      if (!empty($_FILES['foto']['name'])) {
         $config['upload_path'] = './assets/img/upload/';
         $config['allowed_types'] = 'gif|jpg|jpeg|png';
         $config['file_name'] = $id_berita . '_' . time(); // Gunakan nama file yang unik berdasarkan id dan timestamp

         $this->load->library('upload', $config);

         if ($this->upload->do_upload('foto')) {
            // Jika upload berhasil, dapatkan nama file baru
            $upload_data = $this->upload->data();
            $new_photo = $upload_data['file_name'];

            // Hapus file lama jika ada file baru
            if ($old_photo && file_exists('./assets/img/upload/' . $old_photo)) {
               unlink('./assets/img/upload/' . $old_photo);
            }
         }
      }

      // Kumpulkan semua data post
      $post_data = $this->input->post();
      $post_data['foto'] = $new_photo; // Update nama file dengan nama file baru

      $where = array('id_berita' => $id_berita);

      // Simpan data
      $this->M_Berita->Update_Data($where, $post_data, 'tb_berita');

      $data['status'] = "Updated Successfully!";
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }


   private function upload_file_sketch($filename, $id_berita, $table)
   {
      if (!empty($_FILES[$filename]['name'])) {
         $config['upload_path'] = './assets/img/upload/';
         $config['allowed_types'] = 'jpg|png|jpeg|tiff|gif';
         $config['file_ext_tolower'] = TRUE;
         $config['overwrite'] = TRUE;
         $config['max_size']  = '1000000';
         $config['file_name'] = $id_berita . '_' . $filename;

         $this->load->library('upload', $config);
         $this->upload->initialize($config);

         if (!$this->upload->do_upload($filename)) {
            return array('status' => false, 'error' => $this->upload->display_errors());
         } else {
            $data = $this->upload->data();
            $new_filename = $data['file_name'];
            $data_update = array($filename => $new_filename);
            $where = array('id_berita' => $id_berita);
            $this->M_Berita->Update_Data($where, $data_update, $table);
            return array('status' => true, 'file_name' => $new_filename);
         }
      }
      return array('status' => false, 'error' => 'No file uploaded');
   }

   public function ajax_delete()
   {
      $hdrid = $this->input->post('id_berita');
      $berita = $this->db->get_where('tb_berita', array('id_berita' => $hdrid))->row();
      if (is_object($berita)) {
         $photo_path = 'assets/img/berita/';
         $filePaths = [
            $photo_path . $berita->foto
         ];

         foreach ($filePaths as $filePath) {
            if (!empty($filePath) && file_exists($filePath)) {
               chmod($filePath, 0775);
               unlink($filePath);
            }
         }
      }
      $this->M_Berita->Delete_Data(array('id_berita' => $hdrid), 'tb_berita');
      $data['status'] = "Success!";
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }
}
