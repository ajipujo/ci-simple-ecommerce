<?php

class transaction_model extends CI_Model
{
	public function save($data) {
		$this->db->insert('transactions', $data);
		return $this->db->insert_id();
	}
}
