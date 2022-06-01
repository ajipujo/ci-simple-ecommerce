<?php

class produk_model extends CI_Model {
	public function save($data) {
		if ($this->db->insert('products', $data)) {
			return true;
		} else {
			return false;
		}
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
		return $query->row();
	}

	public function getProdukById($id) {
		$this->db->where('deleted_at', null);
		$this->db->where('id', $id);
		$query = $this->db->get('products');
		return $query->row();
	}

	public function update($data, $id) {
		$this->db->set($data);
		$this->db->where('id', $id);
		if ($this->db->update('products')) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteProduk($id) {
		$this->db->set('deleted_at', date('Y-m-d H:i:s'));
		$this->db->where('id', $id);
		if ($this->db->update('products')) {
			return true;
		} else {
			return false;
		}
	}
}
