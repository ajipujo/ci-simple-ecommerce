<?php

class FrontController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('produk_model');
		$this->load->model('produk_tipe_model');
		$this->load->model('user_model');
		$this->load->model('transaction_model');
		$this->load->model('transaction_detail_model');
		$this->load->library('form_validation');
		$this->load->library('user_agent');
	}

	public function index()
	{
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

	public function produk_detail()
	{
		$userdata = null;
		if ($this->session->userdata('loggedIn')) {
			$userdata = [
				'loggedIn' => $this->session->userdata('loggedIn'),
				'userdata' => $this->session->userdata('user')
			];
		}

		$slug = $this->uri->segment(3);

		$produk = $this->produk_model->getProdukBySlug($slug);
		$varian = $this->produk_tipe_model->getVarianByProduk($produk->id);

		$produk->product_types = $varian;

		$data = [
			'title' => 'Situs Jual Beli Termurah dan Terpercaya',
			'page' => 'frontpage/produk',
			'user' => $userdata,
			'produk' => $produk
		];
		$this->load->view('frontpage/layouts/master', $data);
	}

	public function customer_profile()
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
				'page' => 'frontpage/customer_profile',
				'user' => $userdata,
				'user_detail' => $user_detail
			];

			$this->load->view('frontpage/layouts/master', $data);
		} else {
			redirect('/');
		}
	}

	public function update_customer()
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
			$alamat = htmlspecialchars($this->input->post('alamat'));

			$data = [
				'name' => $name,
				'email' => $email,
				'no_hp' => $no_hp,
				'alamat' => $alamat
			];

			$this->user_model->updateUser($data, $id);
			$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Data berhasil diubah']);
			redirect($this->agent->referrer());
		}
	}

	function paycarts()
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
			'page' => 'frontpage/paycarts',
			'user' => $userdata
		];

		$this->load->view('frontpage/layouts/master', $data);
	}

	public function checkout()
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
			'page' => 'frontpage/checkout',
			'user' => $userdata
		];

		$this->load->view('frontpage/layouts/master', $data);
	}

	public function buy()
	{
		$this->isAuthenticated();
		$user = $this->session->userdata('user');
		$harga = $this->input->post('harga[]');
		$qty = $this->input->post('qty[]');
		$produk_id = $this->input->post('produk_id[]');
		$varian_id = $this->input->post('varian_id[]');
		$varian_name = $this->input->post('varian_name[]');
		$produk_name = $this->input->post('produk_name[]');
		$alamat = $this->input->post('alamat');

		$transaction = [
			'user_id' => $user['id'],
			'tanggal_transaksi' => date('Y-m-d H:i:s'),
			'kode_pemesanan' => 'TRS-' . uniqid(),
			'alamat_pemesanan' => $alamat,
			'status_transaksi' => 1,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];

		$id = $this->transaction_model->save($transaction);

		foreach ($produk_id as $key => $value) {
			$detail = [
				'transaction_id' => $id,
				'product_id' => $value,
				'product_type_id' => $varian_id[$key],
				'product_name' => $produk_name[$key],
				'product_type_name' => $varian_name[$key],
				'product_price' => $harga[$key],
				'qty' => $qty[$key],
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			];

			$this->transaction_detail_model->save($detail);
		}

		$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Pembelian berhasil']);
		redirect('/');
	}

	function isAuthenticated()
	{
		if (!$this->session->userdata('loggedIn')) {
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Anda harus login terlebih dahulu']);
			redirect('authcontroller/login');
		} else {
			if ($this->session->userdata('user')['role_id'] != 3) {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Anda harus login terlebih dahulu']);
				redirect('authcontroller/login');
			}
		}
	}
}
