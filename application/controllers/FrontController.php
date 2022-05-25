<?php

class FrontController extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('produk_model');
	}

	public function index() {
		$userdata = null;
		if ($this->session->userdata('loggedIn')) {
			$userdata = [
				'loggedIn' => $this->session->userdata('loggedIn'),
				'userdata' => $this->session->userdata('user')
			];
		}

		$produk = $this->produk_model->getProduk();
		$data = [
			'title' => 'Situs Jual Beli Termurah dan Terpercaya',
			'page' => 'frontpage/index',
			'user' => $userdata,
			'produk' => $produk
		];
		$this->load->view('frontpage/layouts/master', $data);
	}
}
