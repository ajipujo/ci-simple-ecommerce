<?php

class AdminController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('produk_model');
		$this->load->model('produk_tipe_model');
		$this->load->model('user_model');
		$this->load->library('user_agent');
	}

	function isAuthenticated()
	{
		if (!$this->session->userdata('loggedIn')) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Anda harus login terlebih dahulu']);
			redirect('authcontroller/login');
		} else {
			if ($this->session->userdata('user')['role_id'] == 3) {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Anda harus login terlebih dahulu']);
				redirect('authcontroller/login');
			}
		}
	}

	public function index()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];
		$data = [
			'title' => 'Dashboard',
			'page' => 'adminpage/home',
			'user' => $userdata
		];
		$this->load->view('adminpage/layouts/master', $data);
	}

	public function produk()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];
		$produk = $this->produk_model->getProduk();
		$data = [
			'title' => 'Produk',
			'page' => 'adminpage/produk',
			'user' => $userdata,
			'produk' => $produk
		];
		$this->load->view('adminpage/layouts/master', $data);
	}

	public function form_produk()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];
		$data = [
			'title' => 'Tambah Produk',
			'page' => 'adminpage/form_produk',
			'user' => $userdata
		];
		$this->load->view('adminpage/layouts/master', $data);
	}

	public static function createSlug($str, $delimiter = '-')
	{
		$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
		return $slug;
	}

	function generateRandomString($length = 10)
	{
		return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
	}

	public function edit_produk()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];
		$slug = $this->uri->segment(3);
		$produk = $this->produk_model->getProdukBySlug($slug);

		$data = [
			'title' => 'Edit Produk',
			'page' => 'adminpage/edit_produk',
			'user' => $userdata,
			'produk' => $produk
		];
		$this->load->view('adminpage/layouts/master', $data);
	}

	public function delete_produk()
	{
		$this->isAuthenticated();
		$id = $this->input->post('id');
		if ($this->produk_model->deleteProduk($id)) {
			$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Data produk berhasil dihapus!']);
			redirect('admincontroller/produk');
		} else {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Data produk gagal dihapus!']);
			redirect('admincontroller/produk');
		}
	}

	public function update_produk()
	{
		$this->isAuthenticated();
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('stok', 'Stok', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
		$this->form_validation->set_rules('satuan', 'Satuan', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect($this->agent->referrer());
		} else {
			$id = htmlspecialchars($this->input->post('id'));
			$name = htmlspecialchars($this->input->post('name'));
			$harga = htmlspecialchars($this->input->post('harga'));
			$stok = htmlspecialchars($this->input->post('stok'));
			$deskripsi = htmlspecialchars($this->input->post('deskripsi'));
			$satuan = htmlspecialchars($this->input->post('satuan'));

			$old_produk = $this->produk_model->getProdukById($id);

			// var_dump($old_produk);
			// die;

			$data = [
				'name' => $name,
				'harga' => $harga,
				'stok' => $stok,
				'deskripsi' => $deskripsi,
				'satuan' => $satuan,
				'updated_at' => date('Y-m-d H:i:s')
			];

			if ($_FILES['gambar']['name']) {
				$config['upload_path']          = FCPATH . '/upload/produk/';
				$config['allowed_types']        = 'gif|jpg|jpeg|png';
				$config['file_name']            = 'produk-' . $this->generateRandomString() . '-' . time();
				$config['overwrite']            = true;
				$config['max_size']             = 1024; // 1MB

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('gambar')) {
					$data['error'] = $this->upload->display_errors();
					$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
					redirect($this->agent->referrer());
				} else {
					unlink(FCPATH . '/upload/produk/' . $old_produk->gambar);
					$uploaded_data = $this->upload->data();
					$data['gambar'] = $uploaded_data['file_name'];
				}
			}

			if ($this->produk_model->update($data, $id)) {
				$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Data produk berhasil diperbarui!']);
				redirect('admincontroller/produk');
			} else {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Data produk gagal diperbarui!']);
				redirect($this->agent->referrer());
			}
		}
	}

	public function save_produk()
	{
		$this->isAuthenticated();

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('stok', 'Stok', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
		$this->form_validation->set_rules('satuan', 'Satuan', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect('/admincontroller/form_produk');
		} else {
			$name = htmlspecialchars($this->input->post('name'));
			$harga = htmlspecialchars($this->input->post('harga'));
			$stok = htmlspecialchars($this->input->post('stok'));
			$deskripsi = htmlspecialchars($this->input->post('deskripsi'));
			$satuan = htmlspecialchars($this->input->post('satuan'));

			$config['upload_path']          = FCPATH . '/upload/produk/';
			$config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['file_name']            = 'produk-' . $this->generateRandomString() . '-' . time();
			$config['overwrite']            = true;
			$config['max_size']             = 1024; // 1MB

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('gambar')) {
				$data['error'] = $this->upload->display_errors();
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => $data['error']]);
				redirect('/admincontroller/form_produk');
			} else {
				$uploaded_data = $this->upload->data();

				$data = [
					'name' => $name,
					'slug' => $this->createSlug($name),
					'harga' => $harga,
					'stok' => $stok,
					'satuan' => $satuan,
					'gambar' => $uploaded_data['file_name'],
					'deskripsi' => $deskripsi,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				];

				$id_produk = $this->produk_model->save($data);

				if ($id_produk) {

					$varian_name = $this->input->post('varian_name');
					$varian_harga = $this->input->post('varian_harga');
					$varian_gambar = $_FILES['varian_gambar'];

					$cvarian = count($varian_name);

					for ($i=0; $i < $cvarian; $i++) { 
						$config2['upload_path']          = FCPATH . '/upload/varian_produk/';
						$config2['allowed_types']        = 'gif|jpg|jpeg|png';
						$config2['file_name']            = 'varian_produk-' . $this->generateRandomString() . '-' . time();
						$config2['overwrite']            = true;
						$config2['max_size']             = 1024; // 1MB
			
						$_FILES['userfile']['name']= $varian_gambar['name'][$i];
						$_FILES['userfile']['type']= $varian_gambar['type'][$i];
						$_FILES['userfile']['tmp_name']= $varian_gambar['tmp_name'][$i];
						$_FILES['userfile']['error']= $varian_gambar['error'][$i];
						$_FILES['userfile']['size']= $varian_gambar['size'][$i]; 

						$this->load->library('upload', $config2);
						$this->upload->initialize($config2);

						if (!$this->upload->do_upload()) {
							$data['error'] = $this->upload->display_errors();
							$this->session->set_flashdata('message', ['status' => 'danger', 'text' => $data['error']]);
							redirect('/admincontroller/form_produk');
						} else {
							$uploaded_data = $this->upload->data();
			
							$data = [
								'product_id' => $id_produk,
								'name' => $varian_name[$i],
								'harga' => $varian_harga[$i],
								'gambar' => $uploaded_data['file_name'],
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
							];
	
							$this->produk_tipe_model->save($data);
						}
					}

					$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Data produk berhasil ditambahkan!']);
					redirect('admincontroller/produk');
				} else {
					$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Data produk gagal ditambahkan!']);
					redirect('admincontroller/form_produk');
				}
			}
		}
	}

	public function user_admin()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];
		$users = $this->user_model->getUsersByAdminStatus();
		$data = [
			'title' => 'User Admin',
			'page' => 'adminpage/user_admin',
			'user' => $userdata,
			'users' => $users
		];

		$this->load->view('adminpage/layouts/master', $data);
	}

	public function user_customer()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];
		$users = $this->user_model->getUsersByRoleId(3);
		$data = [
			'title' => 'User Admin',
			'page' => 'adminpage/user_customer',
			'user' => $userdata,
			'users' => $users
		];

		$this->load->view('adminpage/layouts/master', $data);
	}

	public function form_user()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];
		$data = [
			'title' => 'User Admin',
			'page' => 'adminpage/form_user',
			'user' => $userdata,
		];

		$this->load->view('adminpage/layouts/master', $data);
	}

	public function save_admin()
	{
		$this->isAuthenticated();
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('role', 'Role', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect('/admincontroller/form_user');
		} else {
			$email = htmlspecialchars($this->input->post('email'));
			$password = htmlspecialchars($this->input->post('password'));
			$role = htmlspecialchars($this->input->post('role'));
			$name = htmlspecialchars($this->input->post('name'));

			$data = [
				'name' => $name,
				'email' => $email,
				'password' => $password,
				'role' => $role
			];

			$existing_email = $this->user_model->getUserByEmail($data);

			if ($existing_email) {
				$this->session->set_flashdata('message', ['status' => 'warning', 'text' => 'Email already registered']);
				redirect('/admincontroller/form_user');
			} else {
				$data = [
					'name' => $name,
					'email' => $email,
					'password' => password_hash($password, PASSWORD_DEFAULT),
					'is_active' => 1,
					'role_id' => $role,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				];

				if ($this->user_model->saveUser($data)) {
					$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Successfully registered']);
					redirect('/admincontroller/user_admin');
				} else {
					$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Failed to register']);
					redirect('/admincontroller/form_user');
				}
			}
		}
	}

	public function form_edit_user()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];

		$id = $this->uri->segment(3);

		if ($id) {
			$userDtl = $this->user_model->getUserById($id);

			if (!$userDtl) {
				redirect('admincontroller/');
			}

			$data = [
				'title' => 'Update User',
				'page' => 'adminpage/form_edit_user',
				'user' => $userdata,
				'user_detail' => $userDtl
			];

			$this->load->view('adminpage/layouts/master', $data);
		} else {
			redirect('/admincontroller');
		}
	}

	public function update_user()
	{
		$this->isAuthenticated();
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect($this->agent->referrer());
		} else {
			$id = htmlspecialchars($this->input->post('id'));
			$email = htmlspecialchars($this->input->post('email'));
			$name = htmlspecialchars($this->input->post('name'));
			$role = htmlspecialchars($this->input->post('role'));
			$no_hp = htmlspecialchars($this->input->post('no_hp'));
			$alamat = htmlspecialchars($this->input->post('alamat'));

			$data = [
				'name' => $name,
				'email' => $email,
				'no_hp' => $no_hp,
				'alamat' => $alamat
			];

			if ($role) {
				$data['role_id'] = $role;
			}

			if ($this->user_model->updateUser($data, $id)) {
				$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Successfully updated']);
				redirect('/admincontroller/user_admin');
			} else {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Failed to update']);
				redirect('/admincontroller/user_admin');
			}
		}
	}
}
