<?php

class produk_tipe_model extends CI_Model {
	public function save($data) {
		if ($this->db->insert('product_types', $data)) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteVarianById($id) {
		$this->db->set('deleted_at', date('Y-m-d H:i:s'));
		$this->db->where('id', $id);
		if ($this->db->update('product_types')) {
			return true;
		} else {
			return false;
		}
	}

	public function update($data, $id) {
		$this->db->where('id', $id);
		if ($this->db->update('product_types', $data)) {
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

	public function getVarianById($id) {
		$this->db->where('deleted_at', null);
		$this->db->where('id', $id);
		$query = $this->db->get('product_types');
		return $query->row();
	}
}
