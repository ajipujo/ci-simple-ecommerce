<?php

class produk_tipe_model extends CI_Model {
	public function save($data) {
		if ($this->db->insert('product_types', $data)) {
			return true;
		} else {
			return false;
		}
	}
}
