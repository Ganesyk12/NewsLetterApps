<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	// public function index()
	// {
	// 	$this->load->view('welcome_message');
	// }
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
		$data['berita'] = $this->M_Berita->get_berita();
		$data['title'] = "Dashboard Agenda";
		$this->load->view('Homepages/layout/header', $data);
		$this->load->view('Homepages/Homepage');
		// $this->load->view('agenda/layout/agenda-js', $data);
		$this->load->view('Homepages/layout/footer', $data);
	}
}
