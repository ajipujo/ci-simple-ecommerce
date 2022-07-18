<?php

class banner_model extends CI_Model {
	public function getHomeBanner() {
		$this->db->select('*');
		$this->db->from('banners');
		$this->db->order_by('created_at', 'desc');
		$this->db->limit(7);
		$query = $this->db->get();
		return $query->result();
	}
}
