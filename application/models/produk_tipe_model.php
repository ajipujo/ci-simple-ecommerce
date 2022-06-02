<?php

class produk_tipe_model extends CI_Model {
	public function save($data) {
		if ($this->db->insert('product_types', $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function getVarianByProduk($id) {
		$this->db->where('deleted_at', null);
		$this->db->where('product_id', $id);
		$query = $this->db->get('product_types');
		return $query->result();
	}
}
