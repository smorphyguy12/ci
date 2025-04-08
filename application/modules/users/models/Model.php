<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Model extends CI_Model {
	function getRow($table, $select = null, $data = [], $join = null) {
		if ($select) $this->db->select($select ?? '*');
		$this->db->from($table);
		if ($join) $this->db->join($join);
		$this->db->where($data); 
	
		return $this->db->get()->row();
	}

	function fetchUser($id) 
	{
		$this->db->from('register');
		$this->db->where('id', $id); 
		return $this->db->get()->row();
	}

	function getUsers(){
		$this->db->from('register');
		return $this->db->get()->result();
	}

	function insertData($table,$data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}

	function updateData($table, $data, $where) {
	    $this->db->where($where);
	    return $this->db->update($table, $data);
	}


	function deleteData($table,$where){
		$this->db->delete($table,$where);
	}
}