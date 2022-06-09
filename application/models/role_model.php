<?php

class role_model extends CI_Model {
	public function getAdminRoles() {
		$this->db->select('*');
		$this->db->from('roles');
		$this->db->where('is_admin', 1);
		$query = $this->db->get();
		return $query->result();
	}
}
