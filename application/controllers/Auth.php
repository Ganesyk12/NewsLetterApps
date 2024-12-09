<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->model('UserModel');
      $this->load->database('default');
      $this->load->helper('date');
      $this->load->library('form_validation');
   }

   public function index()
   {
      if ($this->session->userdata('authenticated'))
         redirect('C_Dashboard');
      $this->render_login('auth/V_Login'); // function render_login tersebut dari file core/MY_Controller.php
   }

   public function regist()
   {
      $mdate = "USR" . mdate('%m%s', time());
      $key = 'id_user';
      $id_user2 = $this->UserModel->Max_data($mdate, $key, 'a_user_system')->row();
      if ($id_user2->id_user == NULL) {
         $id_user3 = $mdate . "001";
      } else {
         $id_user3 = $id_user2->id_user; // Jika sudah ada 
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
      // ********************* 1. Set id_user  *********************
      $post_data2 = array('id_user' => $id_user3);
      $post_data3 = array('username' => $nik_user);
      $post_data4 = array('password' => md5($this->input->post('password')));
      // ******************** 3. Collect all data post *************
      $post_data = $this->input->post();
      $post_datamerge = array_merge($post_data, $post_data2, $post_data3, $post_data4);
      $this->UserModel->Input_Data($post_datamerge, 'a_user_system');
      $data['status'] = 'Success';
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }

   public function add_access()
   {
      $mdate = "RAC" . mdate('%Y%m', time());
      $key = 'hdrid';
      $hdrid2 = $this->UserModel->Max_data($mdate, $key, 'a_role_access')->row();
      if ($hdrid2->hdrid == NULL) {
         $hdrid3 = $mdate . "001";
      } else {
         $hdrid3 = $hdrid2->hdrid;
         $hdrid3 = "RAC" . (intval(substr($hdrid3, 3, 11)) + 1);
      }
      // ********************* 1. Set hdrid  *********************
      $post_data2 = array('hdrid' => $hdrid3);
      // ******************** 3. Collect all data post ***********
      $post_data = $this->input->post();
      $post_datamerge = array_merge($post_data, $post_data2);
      $this->UserModel->Input_Data($post_datamerge, 'a_role_access');
      $data['status'] = 'Success';
      $this->output->set_content_type('application/json')->set_output(json_encode($data));
   }

   public function login()
   {
      $nik = $this->input->post('username');
      $password = $this->input->post('password');
      $user = $this->UserModel->get($nik);
      if (empty($user)) {
         // Jika hasilnya kosong atau user tidak ditemukan
         $this->session->set_flashdata(
            'message',
            '<div class="alert alert-danger" role="alert">
             <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
             <span class="sr-only">Error:</span>
             <i class="fa fa-exclamation-triangle"> </i> User ID not found
             </div>'
         );
         redirect('auth');
      } else {
         if ($password == $user->username) {
            $role_info = $this->UserModel->get_role_info($nik, $user->role_id);
            if (empty($role_info)) {
               $this->session->set_flashdata(
                  'message',
                  '<div class="alert alert-danger" role="alert">
                     <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                     <span class="sr-only">Error:</span>
                     <i class="fa fa-exclamation-triangle"> </i> Anda belum punya access disystem ini
                     </div>'
               );
               redirect('auth');
            }
            $session = array(
               'authenticated' => true,
               'username' => $user->username,
               'name' => $user->nama,
               'role_id' => $role_info->role_id,
            );
            $this->session->set_userdata($session);
            redirect('C_Dashboard');
         } else {
            // Jika password tidak sesuai
            $this->session->set_flashdata(
               'message',
               '<div class="alert alert-danger" role="alert">
                 <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                 <span class="sr-only">Error:</span>
                 <i class="fa fa-exclamation-triangle"> </i> Password is wrong
                 </div>'
            );
            redirect('auth');
         }
      }
   }

   public function logout()
   {
      $this->session->sess_destroy(); // Hapus semua session
      redirect('auth');
   }
}
