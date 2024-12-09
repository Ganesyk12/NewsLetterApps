<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Dashboard extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('date');
      $this->load->helper('file');
      $this->load->model('M_Agenda');
      $this->load->helper('url');
   }

   public function index()
   {
      $data['title'] = "Main Dashboard";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('Dashboard', $data);
      $this->load->view('templates/footer', $data);
   }

   
}
