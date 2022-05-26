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

	function authorized() {
		if ($this->session->userdata('loggedIn')) {
			if ($this->session->userdata('user')['role_id'] == 3) {
				redirect('frontcontroller/index');
			} else {
				redirect('admincontroller/index');
			}
		}
	}

	public function login()
	{
		$this->authorized();
		$data = [
			'title' => 'Login',
			'page' => 'authpage/login'
		];
		$this->load->view('authpage/layouts/master', $data);
	}

	public function register()
	{
		$this->authorized();
		$data = [
			'title' => 'Register',
			'page' => 'authpage/register'
		];
		$this->load->view('authpage/layouts/master', $data);
	}

	public function logout()
	{
		$this->session->unset_userdata('loggedIn');
		$this->session->unset_userdata('user');
		redirect('frontcontroller/index');
	}

	public function authlogin()
	{
		$this->authorized();
		$this->form_validation->set_rules('email', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect('/authcontroller/login');
		} else {
			$email = htmlspecialchars($this->input->post('email'));
			$password = htmlspecialchars($this->input->post('password'));
			
			$data['email'] = $email;

			$user = $this->user_model->getUserByEmail($data);

			if (!$user) {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Email tidak terdaftar']);
				redirect('/authcontroller/login');
			} else {
				$password_validity = password_verify($password, $user->password);
				if ($password_validity) {
					if ($user->is_active != 1) {
						$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'User sudah tidak aktif']);
						redirect('/authcontroller/login');
					} else {
						$userdata = [
							'id' => $user->id,
							'name' => $user->name,
							'role_id' => $user->role_id,
						];
						$this->session->set_userdata('user', $userdata);
						$this->session->set_userdata('loggedIn', true);
						if ($user->role_id == 3) {
							redirect('/');
						} else {
							redirect('/admincontroller/index');
						}
					}
				} else {
					$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Email/Password tidak sesuai']);
					redirect('/authcontroller/login');
				}
			}
		}
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

			if ($user) {
				$this->session->set_flashdata('message', ['status' => 'warning', 'text' => 'Email already registered']);
				redirect('/authcontroller/register');
			} else {
				$data = [
					'name' => $fullname,
					'email' => $email,
					'password' => password_hash($password, PASSWORD_DEFAULT),
					'is_active' => 1,
					'role_id' => 3,
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
