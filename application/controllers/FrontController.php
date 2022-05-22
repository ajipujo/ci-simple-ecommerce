<?php

class FrontController extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
	}

	public function index() {
		$userdata = null;
		if ($this->session->userdata('loggedIn')) {
			$userdata = [
				'loggedIn' => $this->session->userdata('loggedIn'),
				'userdata' => $this->session->userdata('user')
			];
		}
		$data = [
			'title' => 'Situs Jual Beli Termurah dan Terpercaya',
			'page' => 'frontpage/index',
			'user' => $userdata
		];
		$this->load->view('frontpage/layouts/master', $data);
	}
}
