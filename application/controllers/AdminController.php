<?php

class AdminController extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = [
			'title' => 'Admin',
			'page' => 'adminpage/home'
		];
		$this->load->view('adminpage/layouts/master', $data);
	}
}
