<?php

class user_model extends CI_Model {
	public function getUserByEmail($data) {
		$this->db->where('email', $data['email']);
		$query = $this->db->get('users');
		return $query->result();
	}

	public function saveUser($data) {
		$this->db->insert('users', $data);
	}
}
