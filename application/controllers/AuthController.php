<?php

class AuthController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('user_model');
		$this->load->helper('send_mail_helper');
	}

	function authorized()
	{
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

	public function reset_password()
	{
		$this->authorized();
		$data = [
			'title' => 'Reset Password',
			'page' => 'authpage/reset_password'
		];
		$this->load->view('authpage/layouts/master', $data);
	}

	public function send_password()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect($this->agent->referrer());
		} else {
			$email = htmlspecialchars($this->input->post('email'));

			$user = $this->user_model->getUserByEmail(["email" => $email], 3);

			if ($user) {
				$newPassword = $this->generateRandomString(6);
				$data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);

				$this->user_model->updateUser($data, $user->id);

				$subject = 'Reset Password Vavapedia';
				$content = '<html><body><span>Email: <b>' . $user->email . '</b></span><br><span>New password: <b>' . $newPassword . '</b></span></body></html>';

				$params = [
					'subject' => $subject,
					'content' => $content,
					'email_recipient' => 'ajipujo2nd@gmail.com',
					'name_recipient' => $user->name,
				];

				$sendMail = send_mail($params);
				
				if ($sendMail) {
					$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Password has been sent to your email']);
					redirect('authcontroller/login');
				} else {
					$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Failed to send password']);
					redirect('authcontroller/reset_password');
				}
			} else {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Email tidak ditemukan']);
				redirect('authcontroller/reset_password');
			}
		}
	}

	function generateRandomString($length = 10)
	{
		return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
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
							'alamat' => $user->alamat
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
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('no_hp', 'Handphone', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect('/authcontroller/register');
		} else {
			$fullname = htmlspecialchars($this->input->post('fullname'));
			$email = htmlspecialchars($this->input->post('email'));
			$password = htmlspecialchars($this->input->post('password'));
			$no_hp = htmlspecialchars($this->input->post('no_hp'));

			$data = [
				'fullname' => $fullname,
				'email' => $email,
				'password' => $password,
				'no_hp' => $no_hp,
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
					'no_hp' => $no_hp,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				];

				if ($this->user_model->saveUser($data)) {
					$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Successfully registered']);
					redirect('/authcontroller/login');
				} else {
					$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Failed to register']);
					redirect('/authcontroller/register');
				}
			}
		}
	}
}
