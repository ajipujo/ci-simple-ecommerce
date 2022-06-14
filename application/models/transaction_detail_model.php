<?php

class transaction_detail_model extends CI_Model
{
	public function save($data) {
		$this->db->insert('detail_transaction', $data);
	}
}
