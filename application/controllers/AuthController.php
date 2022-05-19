<?php

class AuthController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('user_model');
	}

	public function login()
	{
		$data = [
			'title' => 'Login',
			'page' => 'authpage/login'
		];
		$this->load->view('authpage/layouts/master', $data);
	}

	public function register()
	{
		$data = [
			'title' => 'Register',
			'page' => 'authpage/register'
		];
		$this->load->view('authpage/layouts/master', $data);
	}

	public function authlogin()
	{
		$email = htmlspecialchars($this->input->post('email'));
		$password = htmlspecialchars($this->input->post('password'));
		var_dump($email, $password);
	}

	public function authregister()
	{
		$this->form_validation->set_rules('fullname', 'Username', 'required');
		$this->form_validation->set_rules('email', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect('/authcontroller/register');
		} else {
			$fullname = htmlspecialchars($this->input->post('fullname'));
			$email = htmlspecialchars($this->input->post('email'));
			$password = htmlspecialchars($this->input->post('password'));

			$data = [
				'fullname' => $fullname,
				'email' => $email,
				'password' => $password
			];

			$user = $this->user_model->getUserByEmail($data);

			if (count($user) > 0) {
				$this->session->set_flashdata('message', ['status' => 'warning', 'text' => 'Email already registered']);
				redirect('/authcontroller/register');
			} else {
				$data = [
					'name' => $fullname,
					'email' => $email,
					'password' => password_hash($password, PASSWORD_DEFAULT),
					'is_active' => 1,
					'role' => 3,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				];

				// var_dump($data);
				$this->user_model->saveUser($data);
				$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Successfully registered']);
				redirect('/authcontroller/login');
			}
		}
	}
}
