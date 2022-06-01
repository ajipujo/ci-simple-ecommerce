<?php

class user_model extends CI_Model
{
	public function getUserByEmail($data, $roleId = 0)
	{
		$this->db->where('email', $data['email']);
		if ($roleId) {
			$this->db->where('role_id', $roleId);
		}
		$query = $this->db->get('users');
		return $query->row();
	}

	public function getUserById($id)
	{
		$this->db->select('users.*, roles.role_nm, roles.is_admin');
		$this->db->from('users');
		$this->db->join('roles', 'roles.id = users.role_id');
		$this->db->where('users.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getUsersByRoleId($roleId)
	{
		$this->db->select('users.*, roles.role_nm');
		$this->db->from('users');
		$this->db->join('roles', 'roles.id = users.role_id');
		$this->db->where('role_id', $roleId);
		$query = $this->db->get();
		return $query->result();
	}

	public function getUsersByAdminStatus()
	{
		$this->db->select('users.*, roles.role_nm');
		$this->db->from('users');
		$this->db->join('roles', 'roles.id = users.role_id');
		$this->db->where('is_admin', 1);
		$query = $this->db->get();
		return $query->result();
	}

	public function saveUser($data)
	{
		if ($this->db->insert('users', $data)) {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		} else {
			return false;
		}
	}

	public function updateUser($data, $id)
	{
		$this->db->where('id', $id);
		if ($this->db->update('users', $data)) {
			return true;
		} else {
			return false;
		}
	}
}
