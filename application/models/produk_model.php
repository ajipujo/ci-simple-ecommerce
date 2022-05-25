<?php

class produk_model extends CI_Model {
	public function save($data) {
		$this->db->insert('products', $data);
	}

	public function getProduk() {
		$this->db->where('deleted_at', null);
		$query = $this->db->get('products');
		return $query->result();
	}

	public function getProdukBySlug($slug) {
		$this->db->where('deleted_at', null);
		$this->db->where('slug', $slug);
		$query = $this->db->get('products');
		return $query->row_array();
	}

	public function deleteProduk($id) {
		$this->db->set('deleted_at', date('Y-m-d H:i:s'));
		$this->db->where('id', $id);
		$this->db->update('products');
	}
}
