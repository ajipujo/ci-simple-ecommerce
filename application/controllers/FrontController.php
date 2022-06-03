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

		// var_dump($produk);
		// die;

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

	function searchForId($id, $array) {
		foreach ($array as $item) {
			if ($item->id === $id) {
				return $item;
			}
		}
		return null;
	 }

	public function dummy()
	{
		$dummy = $this->load->view('dummy.json', '', true); //this will load dummy.json
		$dummy = json_decode($dummy);
		$pemasukkan = $dummy->data->pemasukan;
		$pengeluaran = $dummy->data->pengeluaran;

		$allData = [];

		$period = new DatePeriod(
			new DateTime('2022-05-29'),
			new DateInterval('P1D'),
			new DateTime('2022-06-06')
		);

		foreach ($period as $key => $value) {
			$data['tanggal'] = $value->format('Y-m-d');
			$tmp_pemasukkan = [];
			$tmp_pengeluaran = [];
			foreach($pemasukkan as $transaksi) {
				$dateFormatPemasukkan = date("Y-m-d", strtotime($transaksi->created_at));
				if ($dateFormatPemasukkan == $value->format('Y-m-d')) {
					$tmp_pemasukkan[] = $transaksi;
				}
			}
			foreach($pengeluaran as $transaksi) {
				$dateFormatPengeluaran = date("Y-m-d", strtotime($transaksi->tanggal_pengeluaran));
				if ($dateFormatPengeluaran == $value->format('Y-m-d')) {
					$tmp_pengeluaran[] = $transaksi;
				}
			}
			$data['pemasukkan'] = count($tmp_pemasukkan);
			$data['pengeluaran'] = count($tmp_pengeluaran);
			array_push($allData, $data);
		}

		var_dump($allData);
		die;
	}
}
