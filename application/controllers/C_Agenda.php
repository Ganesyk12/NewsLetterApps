<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Agenda extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('date');
      $this->load->helper('file');
      $this->load->helper('url');
      $this->load->database('default');
      $this->load->model('M_Agenda');
   }

   public function index()
   {
      $data['title'] = "Dashboard Agenda";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('agenda/V_Agenda', $data);
      $this->load->view('agenda/layout/agenda-js', $data);
      $this->load->view('templates/footer', $data);
   }

   public function view_data_where()
   {
      $tables = 'tb_agenda';
      $cari = array('id_agenda', 'photo');
      $where = array('timestamp >' => '2022-01-01'); // Jika ada kondisi khusus, tambahkan di sini
      $iswhere = null; // Jika ada kondisi khusus dengan where yang lebih kompleks, tambahkan di sini
      $data = $this->M_Agenda->get_tables_where($tables, $cari, $where, $iswhere);
      echo $data;
   }

   function ajax_getbyhdrid()
   {
      $common = 'id_agenda';
      $key = $this->input->get('id_agenda');
      $data = $this->M_Agenda->ajax_getbyhdrid($common, $key, 'tb_agenda')->row();
      echo json_encode($data);
   }

   public function ajax_add()
   {
      $mdate = "IG" . mdate('%H%m', time());
      $key = 'id_agenda';
      $id_agenda2 = $this->M_Agenda->Max_data($mdate, $key, 'tb_agenda')->row();
      if ($id_agenda2->id_agenda == NULL) {
         $id_agenda = $mdate . "001";
      } else {
         $id_agenda = $id_agenda2->id_agenda;
         $id_agenda = "IG" . (intval(substr($id_agenda, 3, 11)) + 1);
      }
      $post_data2 = array('id_agenda' => $id_agenda);
      // Upload foto
      $foto = isset($_FILES['photo']) ? $_FILES['photo']['name'] : null;
      if (!empty($foto)) {
         $upload_result = $this->upload_file_sketch('photo', $id_agenda, 'tb_agenda');
         if ($upload_result['status']) {
            $post_data2['photo'] = $upload_result['file_name'];
         } else {
            $post_data2['photo'] = null;
         }
      } else {
         $post_data2['photo'] = null;
      }
      // Collect all data post
      $post_data = $this->input->post();
      $post_datamerge = array_merge($post_data, $post_data2);
      $this->M_Agenda->Input_Data($post_datamerge, 'tb_agenda');
      $data['status'] = 'Success';
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }

   public function ajax_update()
   {
      $id_agenda = $this->input->post('id_agenda');
      // Dapatkan nama file lama dari database
      $agenda = $this->M_Agenda->get_by_id($id_agenda);
      $old_photo = $agenda->photo;

      $new_photo = $old_photo;

      if (!empty($_FILES['photo']['name'])) {
         $config['upload_path'] = './assets/img/upload/';
         $config['allowed_types'] = 'gif|jpg|jpeg|png';
         $config['file_name'] = $id_agenda . '_' . time(); // Gunakan nama file yang unik berdasarkan id dan timestamp

         $this->load->library('upload', $config);

         if ($this->upload->do_upload('photo')) {
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
      $post_data['photo'] = $new_photo; // Update nama file dengan nama file baru

      $where = array('id_agenda' => $id_agenda);

      // Simpan data
      $this->M_Agenda->Update_Data($where, $post_data, 'tb_agenda');

      $data['status'] = "Updated Successfully!";
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }


   private function upload_file_sketch($filename, $id_agenda, $table)
   {
      if (!empty($_FILES[$filename]['name'])) {
         $config['upload_path'] = './assets/img/upload/';
         $config['allowed_types'] = 'jpg|png|jpeg|tiff|gif';
         $config['file_ext_tolower'] = TRUE;
         $config['overwrite'] = TRUE;
         $config['max_size']  = '1000000';
         $config['file_name'] = $id_agenda . '_' . $filename;

         $this->load->library('upload', $config);
         $this->upload->initialize($config);

         if (!$this->upload->do_upload($filename)) {
            return array('status' => false, 'error' => $this->upload->display_errors());
         } else {
            $data = $this->upload->data();
            $new_filename = $data['file_name'];
            $data_update = array($filename => $new_filename);
            $where = array('id_agenda' => $id_agenda);
            $this->M_Agenda->Update_Data($where, $data_update, $table);
            return array('status' => true, 'file_name' => $new_filename);
         }
      }
      return array('status' => false, 'error' => 'No file uploaded');
   }

   public function ajax_delete()
   {
      $hdrid = $this->input->post('id_agenda');
      $berita = $this->db->get_where('tb_agenda', array('id_agenda' => $hdrid))->row();
      if (is_object($berita)) {
         $photo_path = 'assets/img/upload/';
         $filePaths = [
            $photo_path . $berita->photo
         ];

         foreach ($filePaths as $filePath) {
            if (!empty($filePath) && file_exists($filePath)) {
               chmod($filePath, 0775);
               unlink($filePath);
            }
         }
      }
      $this->M_Agenda->Delete_Data(array('id_agenda' => $hdrid), 'tb_agenda');
      $data['status'] = "Success!";
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }
}
