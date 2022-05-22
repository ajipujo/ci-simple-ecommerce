<?php

class AdminController extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}

	public function index()
	{
		$userdata = null;
		if ($this->session->userdata('loggedIn')) {
			$userdata = [
				'loggedIn' => $this->session->userdata('loggedIn'),
				'userdata' => $this->session->userdata('user')
			];
		}
		$data = [
			'title' => 'Admin',
			'page' => 'adminpage/home',
			'user' => $userdata
		];
		$this->load->view('adminpage/layouts/master', $data);
	}
}
