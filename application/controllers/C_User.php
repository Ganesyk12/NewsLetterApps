<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_User extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('date');
      $this->load->helper('file');
      $this->load->helper('url');
      $this->load->database('default');
      $this->load->model('UserModel');
   }

   public function index()
   {
      $data['roles'] = $this->UserModel->get_roles();
      $data['title'] = "Dashboard User";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('user/V_User', $data);
      $this->load->view('user/layout/user-js', $data);
      $this->load->view('templates/footer', $data);
   }

   public function view_data_where()
   {
      $tables = 'a_user_system';
      $cari = array('username', 'nama', 'role_id');
      $where = array('timestamp >' => '2022-01-01'); // Jika ada kondisi khusus, tambahkan di sini
      $iswhere = null; // Jika ada kondisi khusus dengan where yang lebih kompleks, tambahkan di sini
      $data = $this->UserModel->get_tables_where($tables, $cari, $where, $iswhere);
      echo $data;
   }

   function ajax_getbyhdrid()
   {
      $common = 'id_user';
      $key = $this->input->get('id_user');
      $data = $this->UserModel->ajax_getbyhdrid($common, $key, 'a_user_system')->row();
      echo json_encode($data);
   }

   public function regist()
   {
      $mdate = "USR" . mdate('%m%s', time());
      $key = 'id_user';
      $id_user2 = $this->UserModel->Max_data($mdate, $key, 'a_user_system')->row();
      if ($id_user2->id_user == NULL) {
         $id_user3 = $mdate . "001";
      } else {
         $id_user3 = $id_user2->id_user;
         $id_user3 = "USR" . (intval(substr($id_user3, 3, 11)) + 1);
      }

      $mdate = "ID" . mdate('%m%s', time());
      $key = 'username';
      $nik_user2 = $this->UserModel->Max_data($mdate, $key, 'a_user_system')->row();
      if ($nik_user2->username == NULL) {
         $nik_user = $mdate . "001";
      } else {
         $nik_user = $nik_user2->username;
         $nik_user = "ID" . (intval(substr($nik_user, 3, 10)) + 1);
      }

      $post_data2 = array('id_user' => $id_user3);

      // Upload foto
      $foto = isset($_FILES['foto']) ? $_FILES['foto']['name'] : null;
      if (!empty($foto)) {
         $upload_result = $this->upload_file_sketch('foto', $id_user3, 'a_user_system');
         if ($upload_result['status']) {
            $post_data2['foto'] = $upload_result['file_name'];
         } else {
            $post_data2['foto'] = null;
         }
      } else {
         $post_data2['foto'] = null;
      }

      $post_data3 = array('username' => $nik_user);
      $post_data4 = array('password' => md5($this->input->post('password')));

      // Collect all data post
      $post_data = $this->input->post();
      $post_datamerge = array_merge($post_data, $post_data2, $post_data3, $post_data4);

      $this->UserModel->Input_Data($post_datamerge, 'a_user_system');

      $data['status'] = 'Success';
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }

   private function upload_file_sketch($filename, $id_user3, $table)
   {
      if (!empty($_FILES[$filename]['name'])) {
         $config['upload_path'] = './assets/img/upload/';
         $config['allowed_types'] = 'jpg|png|jpeg|tiff|gif';
         $config['file_ext_tolower'] = TRUE;
         $config['overwrite'] = TRUE;
         $config['max_size']  = '1000000';
         $config['file_name'] = $id_user3 . '_' . $filename;

         $this->load->library('upload', $config);
         $this->upload->initialize($config);

         if (!$this->upload->do_upload($filename)) {
            return array('status' => false, 'error' => $this->upload->display_errors());
         } else {
            $data = $this->upload->data();
            $new_filename = $data['file_name'];
            $data_update = array($filename => $new_filename);
            $where = array('id_user' => $id_user3);
            $this->UserModel->Update_Data($where, $data_update, $table);
            return array('status' => true, 'file_name' => $new_filename);
         }
      }
      return array('status' => false, 'error' => 'No file uploaded');
   }

   public function ajax_delete()
   {
      $hdrid = $this->input->post('id_user');
      $rework = $this->db->get_where('a_user_system', array('id_user' => $hdrid))->row();
      if (is_object($rework)) {
         $rework_photo_path = 'assets/img/upload/';
         $filePaths = [
            $rework_photo_path . $rework->foto
         ];

         foreach ($filePaths as $filePath) {
            if (!empty($filePath) && file_exists($filePath)) {
               chmod($filePath, 0775);
               unlink($filePath);
            }
         }
      }
      $this->UserModel->Delete_Data(array('id_user' => $hdrid), 'a_user_system');
      $data['status'] = "Success!";
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }

   // public function ajax_update()
   // {
   //    $id_user = $this->input->post('id_user');
   //    $where = array('id_user' => $id_user);
   //    $post_data2 = array('password' => md5($this->input->post('password')));
   //    $post_data = $this->input->post();
   //    $post_datamerge = array_merge($post_data, $post_data2);
   //    // ********************** 3. Simpan data ************************
   //    $this->UserModel->Update_Data($where, $post_datamerge, 'a_user_system');
   //    $data['status'] = "Updated Successfully!";
   //    $this->output->set_content_type('application/json')->set_output(json_encode($data));
   // }

   public function ajax_update()
   {
      $id_user = $this->input->post('id_user');
      // Dapatkan nama file lama dari database
      $user = $this->UserModel->get_by_id($id_user);
      $old_photo = $user->foto;
      $new_photo = $old_photo;
      if (!empty($_FILES['foto']['name'])) {
         $config['upload_path'] = './assets/img/upload/';
         $config['allowed_types'] = 'gif|jpg|jpeg|png';
         $config['file_name'] = $id_user . '_' . time(); // Gunakan nama file yang unik berdasarkan id dan timestamp
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
      $post_data2 = array('password' => md5($this->input->post('password')));
      // Kumpulkan semua data post
      $post_data = $this->input->post();
      $post_data['foto'] = $new_photo; // Update nama file dengan nama file baru
      $where = array('id_user' => $id_user);
      $post_datamerge = array_merge($post_data, $post_data2);
      // Simpan data
      $this->UserModel->Update_Data($where, $post_datamerge, 'a_user_system');

      $data['status'] = "Updated Successfully!";
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }
}
