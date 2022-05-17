<?php

class AuthController extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function login() {
		$data = [
			'title' => 'Login',
			'page' => 'authpage/login'
		];
		$this->load->view('authpage/layouts/master', $data);
	}

	public function register() {
		$data = [
			'title' => 'Register',
			'page' => 'authpage/register'
		];
		$this->load->view('authpage/layouts/master', $data);
	}
}
