<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Contact extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('date');
      $this->load->helper('file');
      $this->load->helper('url');
      $this->load->database('default');
   }

   public function index()
   {
      $data['title'] = "Contact Us";
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('contact/V_Contact', $data);
      $this->load->view('contact/layout/contact-js', $data);
      $this->load->view('templates/footer', $data);
   }
}
