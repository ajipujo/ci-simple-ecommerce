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
		$this->load->model('transaction_model');
		$this->load->model('user_model');
		$this->load->model('role_model');
		$this->load->library('user_agent');
		$this->load->helper('send_mail_helper');
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

		$statistik_transaksi = $this->transaction_model->getStatistikTransaksiByStatus([]);

		$data = [
			'title' => 'Dashboard',
			'page' => 'adminpage/home',
			'user' => $userdata,
			'statistik_transaksi' => $statistik_transaksi
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
		$varian = $this->produk_tipe_model->getVarianByProduk($produk->id);

		$produk->product_types = $varian;

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
		$old_produk = $this->produk_model->getProdukById($id);
		if ($old_produk) {
			unlink(FCPATH . '/upload/produk/' . $old_produk->gambar);
			if ($this->produk_model->deleteProduk($id)) {
				$varian = $this->produk_tipe_model->getVarianByProduk($id);
				foreach ($varian as $item) {
					unlink(FCPATH . '/upload/varian_produk/' . $item->gambar);
					$this->produk_tipe_model->deleteVarianById($item->id);
				}
				$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Data produk berhasil dihapus!']);
				redirect('admincontroller/produk');
			} else {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Data produk gagal dihapus!']);
				redirect('admincontroller/produk');
			}
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
			$deskripsi = $this->input->post('deskripsi');
			$satuan = htmlspecialchars($this->input->post('satuan'));

			$old_produk = $this->produk_model->getProdukById($id);

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
				$varian_id = $this->input->post('varian_id');
				$varian_name = $this->input->post('varian_name');
				$varian_harga = $this->input->post('varian_harga');
				$varian_gambar = $_FILES['varian_gambar'];

				$cvarian = count($varian_name);

				$config2['upload_path']          = FCPATH . '/upload/varian_produk/';
				$config2['allowed_types']        = 'gif|jpg|jpeg|png';
				$config2['file_name']            = 'varian_produk-' . $this->generateRandomString() . '-' . time();
				$config2['overwrite']            = true;
				$config2['max_size']             = 1024; // 1MB

				for ($i = 0; $i < $cvarian; $i++) {
					$id_varian = $varian_id[$i];
					$data = [
						'name' => $varian_name[$i],
						'harga' => $varian_harga[$i],
						'updated_at' => date('Y-m-d H:i:s')
					];

					if ($id_varian) {

						$old_varian = $this->produk_tipe_model->getVarianById($id_varian);

						if ($varian_gambar['name'][$i]) {
							$_FILES['userfile']['name'] = $varian_gambar['name'][$i];
							$_FILES['userfile']['type'] = $varian_gambar['type'][$i];
							$_FILES['userfile']['tmp_name'] = $varian_gambar['tmp_name'][$i];
							$_FILES['userfile']['error'] = $varian_gambar['error'][$i];
							$_FILES['userfile']['size'] = $varian_gambar['size'][$i];

							$this->load->library('upload', $config2);
							$this->upload->initialize($config2);

							if (!$this->upload->do_upload()) {
								$data['error'] = $this->upload->display_errors();
								$this->session->set_flashdata('message', ['status' => 'danger', 'text' => $data['error']]);
								redirect($this->agent->referrer());
							} else {
								$uploaded_data = $this->upload->data();
								unlink(FCPATH . '/upload/varian_produk/' . $old_varian->gambar);
								$data['gambar'] = $uploaded_data['file_name'];
							}
						}

						$this->produk_tipe_model->update($data, $id_varian);
					} else {
						$_FILES['userfile']['name'] = $varian_gambar['name'][$i];
						$_FILES['userfile']['type'] = $varian_gambar['type'][$i];
						$_FILES['userfile']['tmp_name'] = $varian_gambar['tmp_name'][$i];
						$_FILES['userfile']['error'] = $varian_gambar['error'][$i];
						$_FILES['userfile']['size'] = $varian_gambar['size'][$i];

						$this->load->library('upload', $config2);
						$this->upload->initialize($config2);

						if (!$this->upload->do_upload()) {
							$data['error'] = $this->upload->display_errors();
							$this->session->set_flashdata('message', ['status' => 'danger', 'text' => $data['error']]);
							redirect($this->agent->referrer());
						} else {
							$uploaded_data = $this->upload->data();

							$data = [
								'product_id' => $id,
								'name' => $varian_name[$i],
								'harga' => $varian_harga[$i],
								'gambar' => $uploaded_data['file_name'],
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s')
							];

							$this->produk_tipe_model->save($data);
						}
					}
				}

				$varian_delete_datas = $this->input->post('varian_delete_datas');
				if ($varian_delete_datas) {
					$dataDelete = explode(',', $varian_delete_datas);
				} else {
					$dataDelete = [];
				}

				foreach ($dataDelete as $id) {
					$old_varian = $this->produk_tipe_model->getVarianById($id);
					unlink(FCPATH . '/upload/varian_produk/' . $old_varian->gambar);
					$this->produk_tipe_model->deleteVarianById($id);
				}

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
			$deskripsi = $this->input->post('deskripsi');
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

					for ($i = 0; $i < $cvarian; $i++) {
						$config2['upload_path']          = FCPATH . '/upload/varian_produk/';
						$config2['allowed_types']        = 'gif|jpg|jpeg|png';
						$config2['file_name']            = 'varian_produk-' . $this->generateRandomString() . '-' . time();
						$config2['overwrite']            = true;
						$config2['max_size']             = 1024; // 1MB

						$_FILES['userfile']['name'] = $varian_gambar['name'][$i];
						$_FILES['userfile']['type'] = $varian_gambar['type'][$i];
						$_FILES['userfile']['tmp_name'] = $varian_gambar['tmp_name'][$i];
						$_FILES['userfile']['error'] = $varian_gambar['error'][$i];
						$_FILES['userfile']['size'] = $varian_gambar['size'][$i];

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
			$no_hp = htmlspecialchars($this->input->post('no_hp'));

			$data = [
				'name' => $name,
				'email' => $email,
				'password' => $password,
				'role' => $role,
				'no_hp' => $no_hp,
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
					'no_hp' => $no_hp,
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
			$adminRoles = $this->role_model->getAdminRoles();

			if (!$userDtl) {
				redirect('admincontroller/');
			}

			$data = [
				'title' => 'Update User',
				'page' => 'adminpage/form_edit_user',
				'user' => $userdata,
				'user_detail' => $userDtl,
				'adminRoles' => $adminRoles
			];

			$this->load->view('adminpage/layouts/master', $data);
		} else {
			redirect('/admincontroller');
		}
	}

	public function ganti_password()
	{
		$this->isAuthenticated();
		if ($this->session->userdata('loggedIn')) {
			$userdata = [
				'loggedIn' => $this->session->userdata('loggedIn'),
				'userdata' => $this->session->userdata('user')
			];
		}
		$data = [
			'title' => 'Situs Jual Beli Termurah dan Terpercaya',
			'page' => 'adminpage/ganti_password',
			'user' => $userdata
		];

		$this->load->view('adminpage/layouts/master', $data);
	}

	public function update_password()
	{
		$this->isAuthenticated();
		$id = $this->session->userdata('user')['id'];

		$this->form_validation->set_rules('password_lama', 'Password Lama', 'required');
		$this->form_validation->set_rules('password_baru', 'Password Baru', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect($this->agent->referrer());
		} else {
			$password_lama = htmlspecialchars($this->input->post('password_lama'));
			$password_baru = htmlspecialchars($this->input->post('password_baru'));

			$user = $this->user_model->getUserById($id);

			$password_validity = password_verify($password_lama, $user->password);

			if ($password_validity) {
				$password_baru = password_hash($password_baru, PASSWORD_DEFAULT);

				$data['password'] = $password_baru;
				$data['updated_at'] = date('Y-m-d H:i:s');

				$this->user_model->updateUser($data, $id);

				$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Password berhasil diubah']);
				redirect('admincontroller/admin_profile/' . $id);
			} else {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Password lama anda salah']);
				redirect($this->agent->referrer());
			}
		}
	}

	public function admin_profile()
	{
		$this->isAuthenticated();
		if ($this->session->userdata('user')['id'] != $this->uri->segment(3)) {
			redirect('/');
		}
		if ($this->session->userdata('loggedIn')) {
			$userdata = [
				'loggedIn' => $this->session->userdata('loggedIn'),
				'userdata' => $this->session->userdata('user')
			];
		}

		$id = $this->uri->segment(3);

		if ($id) {
			$user_detail = $this->user_model->getUserById($id);

			$data = [
				'title' => 'Situs Jual Beli Termurah dan Terpercaya',
				'page' => 'adminpage/admin_profile',
				'user' => $userdata,
				'user_detail' => $user_detail
			];

			$this->load->view('adminpage/layouts/master', $data);
		} else {
			redirect('/');
		}
	}

	public function update_admin()
	{
		$this->isAuthenticated();
		if ($this->session->userdata('user')['id'] != htmlspecialchars($this->input->post('id'))) {
			redirect('/');
		}
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect($this->agent->referrer());
		} else {
			$id = htmlspecialchars($this->input->post('id'));
			$name = htmlspecialchars($this->input->post('name'));
			$email = htmlspecialchars($this->input->post('email'));
			$no_hp = htmlspecialchars($this->input->post('no_hp'));

			$data = [
				'name' => $name,
				'email' => $email,
				'no_hp' => $no_hp
			];

			$this->user_model->updateUser($data, $id);
			$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Data berhasil diubah']);
			redirect($this->agent->referrer());
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

	public function reset_password()
	{
		$this->isAuthenticated();
		$id = htmlspecialchars($this->uri->segment(3));
		if ($id) {
			$user = $this->user_model->getUserById($id);

			if ($user) {
				$newPassword = $this->generateRandomString(6);
				$data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);

				$this->user_model->updateUser($data, $user->id);

				$subject = 'Reset Password Vavapedia';
				$content = '<html><body><span>Email: <b>' . $user->email . '</b></span><br><span>New password: <b>' . $newPassword . '</b></span></body></html>';

				$params = [
					'subject' => $subject,
					'content' => $content,
					'email_recipient' => $user->email,
					'name_recipient' => $user->name,
				];

				$sendMail = send_mail($params);

				if ($sendMail) {
					$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Password has been sent to your email']);
					redirect($this->agent->referrer());
				} else {
					$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Failed to send password']);
					redirect($this->agent->referrer());
				}
			} else {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Email tidak ditemukan']);
				redirect($this->agent->referrer());
			}
		} else {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Email tidak ditemukan']);
			redirect($this->agent->referrer());
		}
	}

	public function transaksi()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];

		$transaksi = $this->transaction_model->getAllTransaksi();

		$data = [
			'title' => 'Transaksi',
			'page' => 'adminpage/transaksi',
			'user' => $userdata,
			'transaksi' => $transaksi
		];

		$this->load->view('adminpage/layouts/master', $data);
	}

	public function view_transaksi()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];

		$kode_pemesanan = $this->uri->segment(3);

		$transaksi = $this->transaction_model->getTransaksiByKode($kode_pemesanan);

		if (!$transaksi) {
			redirect('/admincontroller/transaksi');
		}

		$data = [
			'title' => 'Transaksi',
			'page' => 'adminpage/view_transaksi',
			'user' => $userdata,
			'transaksi' => $transaksi
		];

		$this->load->view('adminpage/layouts/master', $data);
	}

	public function next_process()
	{
		$this->isAuthenticated();
		$kode_transaksi = htmlspecialchars($this->input->post('kode_transaksi'));
		$transaksi = $this->transaction_model->getTransaksiByKode($kode_transaksi);

		if ($transaksi) {
			switch ($transaksi->status_transaksi) {
				case 1:
					$next_process = 2;
					break;
				case 3:
					$next_process = 4;
					break;
				case 6:
					$next_process = 3;
					break;

				default:
					$next_process = false;
					break;
			}

			if ($next_process) {
				$data = [
					'status_transaksi' => $next_process,
					'updated_at' => date('Y-m-d H:i:s')
				];

				if ($next_process == 4) {
					$resi = htmlspecialchars($this->input->post('resi_pemesanan'));
					$data['resi_pemesanan'] = $resi;
				}

				if ($next_process == 2) {
					$data['batas_pembayaran'] = date('Y-m-d H:i:s', strtotime('+1 day'));
				}

				if ($next_process == 3) {
					$data['batas_pembayaran'] = null;
				}

				$this->transaction_model->updateTransaksi($data, $kode_transaksi);

				if ($next_process == 2) {
					$subject = 'Pemesanan dikonfirmasi - ' . $kode_transaksi;
					$content = '<html> <body> <span>Pemesanan dengan nomor transaksi <b>' . $kode_transaksi . '</b> telah dikonfirmasi. Silahkan lakukan pembayaran (di halaman detail transaksi), batas pembayaran 24 jam setelah transaksi dikonfirmasi.</span> </body> </html>';

					$params = [
						'subject' => $subject,
						'content' => $content,
						'email_recipient' => $transaksi->user_email,
						'name_recipient' => $transaksi->user_name,
					];

					$sendMail = send_mail($params);
					if (!$sendMail) {
						$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Notifikasi order gagal dikirim']);
						redirect('/admincontroller/transaksi');
					}
				}

				if ($next_process == 3) {
					$subject = 'Pembayaran dikonfirmasi - ' . $kode_transaksi;
					$content = '<html> <body> <span>Pembayaran dengan nomor transaksi <b>' . $kode_transaksi . '</b> telah dikonfirmasi. Pesanan akan segera diproses.</span> </body> </html>';

					$params = [
						'subject' => $subject,
						'content' => $content,
						'email_recipient' => $transaksi->user_email,
						'name_recipient' => $transaksi->user_name,
					];

					$sendMail = send_mail($params);
					if (!$sendMail) {
						$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Notifikasi order gagal dikirim']);
						redirect('/admincontroller/transaksi');
					}
				}

				if ($next_process == 4) {
					$subject = 'Pesanan telah dikirim - ' . $kode_transaksi;
					$content = '<html> <body> <span>Pesanan dengan nomor transaksi <b>' . $kode_transaksi . '</b> telah dikirim dengan nomor resi: <b>' . htmlspecialchars($this->input->post('resi_pemesanan')) . '<b></span> </body> </html>';

					$params = [
						'subject' => $subject,
						'content' => $content,
						'email_recipient' => $transaksi->user_email,
						'name_recipient' => $transaksi->user_name,
					];

					$sendMail = send_mail($params);
					if (!$sendMail) {
						$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Notifikasi order gagal dikirim']);
						redirect('/admincontroller/transaksi');
					}
				}

				$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Status order berhasil diperbarui']);
				redirect('/admincontroller/transaksi');
			} else {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Status order gagal diperbarui']);
				redirect('/admincontroller/transaksi');
			}
		} else {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Status order gagal diperbarui']);
			redirect('/admincontroller/transaksi');
		}
	}

	public function cancel_order()
	{
		$this->isAuthenticated();

		$kode_transaksi = htmlspecialchars($this->input->post('kode_transaksi'));

		$transaksi = $this->transaction_model->getTransaksiByKode($kode_transaksi);

		if ($transaksi) {
			$data = [
				'status_transaksi' => 5,
				'updated_at' => date('Y-m-d H:i:s')
			];
			$this->transaction_model->updateTransaksi($data, $kode_transaksi);

			$subject = 'Pemesanan dibatalkan - ' . $kode_transaksi;
			$content = '<html> <body> <span>Pemesanan dengan nomor transaksi <b>' . $kode_transaksi . '</b> telah dibatalkan.</span> </body> </html>';

			$params = [
				'subject' => $subject,
				'content' => $content,
				'email_recipient' => $transaksi->user_email,
				'name_recipient' => $transaksi->user_name,
			];

			$sendMail = send_mail($params);

			if ($sendMail) {
				$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Pembatalan order berhasil dilakukan']);
				redirect('/admincontroller/transaksi');
			} else {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Pengiriman notifikasi gagal dilakukan']);
				redirect('/admincontroller/transaksi');
			}
		} else {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Pembatalan order gagal dilakukan']);
			redirect('/admincontroller/transaksi');
		}
	}

	public function cancel_pembayaran()
	{
		$this->isAuthenticated();

		$kode_transaksi = htmlspecialchars($this->input->post('kode_transaksi'));

		$transaksi = $this->transaction_model->getTransaksiByKode($kode_transaksi);

		if ($transaksi) {
			unlink(FCPATH . '/upload/bukti_pembayaran/' . $transaksi->bukti_pembayaran);
			$data = [
				'batas_pembayaran' => date('Y-m-d H:i:s', strtotime('+1 day')),
				'bukti_pembayaran' => null,
				'status_transaksi' => 2,
				'updated_at' => date('Y-m-d H:i:s')
			];
			$this->transaction_model->updateTransaksi($data, $kode_transaksi);

			$subject = 'Bukti Pembayaran Invalid - ' . $kode_transaksi;
			$content = '<html> <body> <span>Bukti pembayaran untuk transaksi <b>' . $kode_transaksi . '</b> tidak valid. Silahkan upload bukti pembayaran kembali.</span> </body> </html>';

			$params = [
				'subject' => $subject,
				'content' => $content,
				'email_recipient' => $transaksi->user_email,
				'name_recipient' => $transaksi->user_name,
			];

			$sendMail = send_mail($params);

			if ($sendMail) {
				$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Bukti pembayaran berhasil dicancel']);
				redirect('/admincontroller/transaksi');
			} else {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Notifikasi gagal dikirim']);
				redirect('/admincontroller/transaksi');
			}
		} else {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Bukti pembayaran gagal dicancel']);
			redirect('/admincontroller/transaksi');
		}
	}

	public function laporan_keuangan()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];

		$data = [
			'title' => 'Transaksi',
			'page' => 'adminpage/laporan_keuangan',
			'user' => $userdata
		];

		$status_transaksi = $this->db->get('status_transaction')->result();
		$data['status_transaksi'] = $status_transaksi;

		$this->load->view('adminpage/layouts/master', $data);
	}

	public function cetak_laporan()
	{
		$this->isAuthenticated();
		$startDate = htmlspecialchars($this->input->post('dateStartInput'));
		$endDate = htmlspecialchars($this->input->post('dateEndInput'));
		$statusTransaksi = htmlspecialchars($this->input->post('status_transaksi'));

		$startDate = date('Y-m-d H:i:s', strtotime($startDate));
		$endDate = date('Y-m-d H:i:s', strtotime($endDate . ' +1 day'));

		$startDateLabel = date('Y-m-d', strtotime($startDate));
		$endDateLabel = date('Y-m-d', strtotime($endDate));

		$store['store'] = $this->transaction_model->getTransaksiByDateRange($startDate, $endDate, $statusTransaksi);
		$store['startDate'] = $startDateLabel;
		$store['endDate'] = $endDateLabel;

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4-L',
			'orientation' => 'L'
		]);
		$html = $this->load->view('documents/laporan_penjualan', $store, true);

		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}

	public function manajemen_compro()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];
		$compro = $this->db->get('profil_perusahaan')->row();

		$data = [
			'title' => 'Perusahaan',
			'page' => 'adminpage/manajemen_compro',
			'user' => $userdata,
			'compro' => $compro
		];

		$this->load->view('adminpage/layouts/master', $data);
	}

	public function banner()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];

		$banners = $this->db->order_by('created_at', 'DESC')->get('banners')->result();

		$data = [
			'title' => 'Banner',
			'page' => 'adminpage/banner',
			'user' => $userdata,
			'banners' => $banners
		];

		$this->load->view('adminpage/layouts/master', $data);
	}

	public function add_banner()
	{
		$this->isAuthenticated();
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect($this->agent->referrer());
		} else {
			$keterangan = htmlspecialchars($this->input->post('keterangan'));
			$config['upload_path']          = FCPATH . '/upload/banner/';
			$config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['file_name']            = 'banner-' . $this->generateRandomString() . '-' . time();
			$config['overwrite']            = true;
			$config['max_size']             = 1024; // 1MB

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('gambar')) {
				$data['error'] = $this->upload->display_errors();
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => $data['error']]);
				redirect($this->agent->referrer());
			} else {
				$uploaded_data = $this->upload->data();

				$data = [
					'gambar' => $uploaded_data['file_name'],
					'keterangan' => $keterangan,
					'is_active' => 1,
					'created_at' => date('Y-m-d H:i:s'),
				];

				$this->db->insert('banners', $data);
				$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Banner berhasil ditambahkan']);
				redirect('admincontroller/banner');
			}
		}
	}

	public function delete_banner()
	{
		$this->isAuthenticated();
		$id = $this->uri->segment(3);

		if ($id) {
			$banner = $this->db->get_where('banners', ['id' => $id])->row();

			unlink(FCPATH . '/upload/banner/' . $banner->gambar);

			$this->db->where('id', $id);
			$this->db->delete('banners');
			$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Banner berhasil dihapus']);
			redirect('admincontroller/banner');
		} else {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Banner tidak ditemukan']);
			redirect($this->agent->referrer());
		}
	}

	public function kontak()
	{
		$this->isAuthenticated();
		$userdata = [
			'loggedIn' => $this->session->userdata('loggedIn'),
			'userdata' => $this->session->userdata('user')
		];
		$kontak = $this->db->order_by('created_at', 'DESC')->get('kontak_perusahaan')->result();
		$data = [
			'title' => 'Kontak',
			'page' => 'adminpage/kontak',
			'user' => $userdata,
			'kontak' => $kontak
		];

		$this->load->view('adminpage/layouts/master', $data);
	}

	public function add_kontak()
	{
		$this->isAuthenticated();
		$this->form_validation->set_rules('no_hp', 'No. Handphone', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect($this->agent->referrer());
		} else {
			$no_hp = htmlspecialchars($this->input->post('no_hp'));
			$nama = htmlspecialchars($this->input->post('nama'));
			$data = [
				'no_hp' => $no_hp,
				'nama' => $nama,
				'created_at' => date('Y-m-d H:i:s'),
			];
			$this->db->insert('kontak_perusahaan', $data);
			$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Kontak berhasil ditambahkan']);
			redirect('admincontroller/kontak');
		}
	}

	public function delete_kontak()
	{
		$this->isAuthenticated();
		$id = $this->uri->segment(3);

		if ($id) {
			$this->db->where('id', $id);
			$this->db->delete('kontak_perusahaan');
			$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Kontak berhasil dihapus']);
			redirect('admincontroller/kontak');
		} else {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Kontak tidak ditemukan']);
			redirect($this->agent->referrer());
		}
	}

	public function update_compro()
	{
		$this->isAuthenticated();
		$this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required');
		$this->form_validation->set_rules('alamat_perusahaan', 'alamat_deskripsi', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect($this->agent->referrer());
		} else {
			$data = [
				'nama_perusahaan' => htmlspecialchars($this->input->post('nama_perusahaan')),
				'alamat_perusahaan' => htmlspecialchars($this->input->post('alamat_perusahaan')),
				'deskripsi_perusahaan' => $this->input->post('deskripsi_perusahaan'),
			];
			$this->db->update('profil_perusahaan', $data);
			$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Perusahaan berhasil diperbarui']);
			redirect($this->agent->referrer());
		}
	}

	public function update_resi()
	{
		$this->isAuthenticated();
		$resi = htmlspecialchars($this->input->post('input_resi'));
		$kode_pemesanan = htmlspecialchars($this->input->post('kode_pemesanan'));
		$transaksi = $this->transaction_model->getTransaksiByKode($kode_pemesanan);

		if ($transaksi) {
			$data = [
				'resi_pemesanan' => $resi,
				'updated_at' => date('Y-m-d H:i:s')
			];

			$this->transaction_model->updateTransaksi($data, $kode_pemesanan);
			$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Resi pemesanan berhasil diperbarui']);
			redirect($this->agent->referrer());
		} else {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Status order gagal diperbarui']);
			redirect($this->agent->referrer());
		}		
	}
}
