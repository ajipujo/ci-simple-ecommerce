<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

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

	function generateRandomString($length = 10)
	{
		return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
	}

	public function index()
	{
		$userdata = null;
		if ($this->session->userdata('loggedIn')) {
			$userdata = [
				'loggedIn' => $this->session->userdata('loggedIn'),
				'userdata' => $this->session->userdata('user')
			];

			if ($userdata['userdata']['role_id'] == 3) {
				$user_dtl = $this->user_model->getUserById($userdata['userdata']['id']);
				if (!$user_dtl->alamat) {
					$this->session->set_flashdata('message_user', ['status' => 'warning', 'text' => 'Silahkan lengkapi data diri anda terlebih dahulu']);
				}
			}
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
			'page' => 'frontpage/ganti_password',
			'user' => $userdata
		];

		$this->load->view('frontpage/layouts/master', $data);
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
				redirect('frontcontroller/customer_profile/'.$id);
			} else {
				$this->session->set_flashdata('message', ['status' => 'danger', 'text' => 'Password lama anda salah']);
				redirect($this->agent->referrer());
			}
		}
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
				'alamat' => $alamat,
				'updated_at' => date('Y-m-d H:i:s')
			];

			$this->user_model->updateUser($data, $id);
			$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Data berhasil diubah']);
			redirect($this->agent->referrer());
		}
	}

	public function transaksi()
	{
		$this->isAuthenticated();
		if ($this->session->userdata('loggedIn')) {
			$userdata = [
				'loggedIn' => $this->session->userdata('loggedIn'),
				'userdata' => $this->session->userdata('user')
			];
		}

		$transactions = $this->transaction_model->getTransactionsByUserId($this->session->userdata('user')['id']);

		$data = [
			'title' => 'Transaksi',
			'page' => 'frontpage/transaksi',
			'user' => $userdata,
			'transaksi' => $transactions,
		];

		$this->load->view('frontpage/layouts/master', $data);
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
			redirect('/frontcontroller/transaksi');
		}

		$data = [
			'title' => 'Transaksi',
			'page' => 'frontpage/view_transaksi',
			'user' => $userdata,
			'transaksi' => $transaksi
		];

		$this->load->view('frontpage/layouts/master', $data);
	}

	public function upload_pembayaran()
	{
		$this->isAuthenticated();
		$kode_pemesanan = htmlspecialchars($this->input->post('kode_pemesanan'));

		$transaksi = $this->transaction_model->getTransaksiByKode($kode_pemesanan);

		if (!$transaksi) {
			redirect('/frontcontroller/transaksi');
		}

		$config['upload_path']          = FCPATH . '/upload/bukti_pembayaran/';
		$config['allowed_types']        = 'gif|jpg|jpeg|png';
		$config['file_name']            = 'bukti-' . $this->generateRandomString() . '-' . time();
		$config['overwrite']            = true;
		$config['max_size']             = 1024; // 1MB

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('bukti_pembayaran')) {
			$data['error'] = $this->upload->display_errors();
			$this->session->set_flashdata('message', ['status' => 'danger', 'text' => $data['error']]);
			redirect($this->agent->referrer());
		} else {
			$uploaded_data = $this->upload->data();
			$data = [
				'batas_pembayaran' => null,
				'bukti_pembayaran' => $uploaded_data['file_name'],
				'status_transaksi' => 6,
				'updated_at' => date('Y-m-d H:i:s')
			];
			$this->transaction_model->updateTransaksi($data, $kode_pemesanan);
			$this->session->set_flashdata('message', ['status' => 'success', 'text' => 'Bukti pembayaran berhasil diupload!']);
			redirect('frontcontroller/transaksi');
		}
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

		$user_detail = $this->user_model->getUserById($this->session->userdata('user')['id']);

		$data = [
			'title' => 'Situs Jual Beli Termurah dan Terpercaya',
			'page' => 'frontpage/checkout',
			'user' => $userdata,
			'user_detail' => $user_detail
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
