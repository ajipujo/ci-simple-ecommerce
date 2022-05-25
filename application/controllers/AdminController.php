<?php

class AdminController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('produk_model');
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

	public static function createSlug($str, $delimiter = '-'){
		$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
		return $slug;
	} 

	function generateRandomString($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	public function delete_produk() {
		$this->isAuthenticated();
		$id = $this->input->post('id');
		$this->produk_model->deleteProduk($id);
		$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Data produk berhasil dihapus!']);
		redirect('admincontroller/produk');
	}

	public function save_produk()
	{
		$this->isAuthenticated();
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('stok', 'Stok', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => validation_errors()]);
			redirect('/admincontroller/form_produk');
		} else {
			$name = htmlspecialchars($this->input->post('name'));
			$harga = htmlspecialchars($this->input->post('harga'));
			$stok = htmlspecialchars($this->input->post('stok'));

			$config['upload_path']          = FCPATH . '/upload/produk/';
			$config['allowed_types']        = 'gif|jpg|jpeg|png';
			$config['file_name']            = 'produk-'. $this->generateRandomString() . '-' . time();
			$config['overwrite']            = true;
			$config['max_size']             = 1024; // 1MB

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('gambar')) {
				$data['error'] = $this->upload->display_errors();
				var_dump($data['error']);
				die;
			} else {
				$uploaded_data = $this->upload->data();
	
				$data = [
					'name' => $name,
					'slug' => $this->createSlug($name),
					'harga' => $harga,
					'stok' => $stok,
					'gambar' => $uploaded_data['file_name'],
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				];
		
				$this->produk_model->save($data);
				$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Data produk berhasil ditambahkan!']);
				redirect('admincontroller/produk');
			}
		}
	}
}
