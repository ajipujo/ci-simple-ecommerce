<?php

class transaction_model extends CI_Model
{
	public function save($data) {
		$this->db->insert('transactions', $data);
		return $this->db->insert_id();
	}

	public function getAllTransaksi() {

		$datas = [];

		$this->db->select('transactions.*, users.name as user_name, status_transaction.name as status_name');
		$this->db->from('transactions');
		$this->db->join('users', 'users.id = transactions.user_id');
		$this->db->join('status_transaction', 'status_transaction.id = transactions.status_transaksi');

		$transactions = $this->db->get();

		foreach ($transactions->result() as $transaction) {
			$details = [];
			$detail_transaction = $this->getDetailByTransactionId($transaction->id);
			if ($detail_transaction) {
				$details = $detail_transaction;
			}
			$transaction->detail = $details;
			$datas[] = $transaction;
		}

		return $datas;
	}

	function getDetailByTransactionId($id) {
		$this->db->select('detail_transaction.*');
		$this->db->from('detail_transaction');
		$this->db->join('products', 'products.id = detail_transaction.product_id');
		$this->db->where('transaction_id', $id);
		$detail_transactions = $this->db->get();
		return $detail_transactions->result();
	}
}
