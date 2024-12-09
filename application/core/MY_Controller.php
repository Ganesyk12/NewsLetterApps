<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

   public function __construct()
   {
      parent::__construct();
      $this->authenticated(); // Panggil fungsi authenticated
   }

   public function authenticated()
   {
      if ($this->uri->segment(1) != 'auth' && $this->uri->segment(1) != '') {
         // Cek apakah terdapat session dengan nama authenticated
         if (!$this->session->userdata('authenticated')) // Jika tidak ada / artinya belum login
            redirect('auth'); // Redirect ke halaman login
      }
   }

   public function render_login($content, $data = NULL)
   { // kembali ke login

      $data['contentnya'] = $this->load->view($content, $data, TRUE);
      $data['menu'] = $this->UserModel->get_menu();
      $data['roles'] = $this->UserModel->get_roles();
      $data['title'] = "Login Page";
      $this->load->view('auth/layout/header', $data);
      $this->load->view('auth/V_Login', $data);
      $this->load->view('auth/layout/footer');
   }
}
