<?php

class UtilController extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->dbutil();
	}

	public function test_db() {
		if( !$this->dbutil->database_exists('db_penjualan_iva')) {
			echo 'Not connected to a database, or database not exists';
		} else {
			echo 'Database connected as well';
		}
	}

	public function home() {
		redirect('frontcontroller/index');
	}
}
