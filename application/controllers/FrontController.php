<?php

class FrontController extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$data = [
			'title' => 'Situs Jual Beli Termurah dan Terpercaya',
			'page' => 'frontpage/index'
		];
		$this->load->view('frontpage/layouts/master', $data);
	}
}
