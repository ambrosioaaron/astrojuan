<?php

class Model_accounts extends CI_Model
{
	public function validate_login($email, $password)
	{
		$this->db->where('Email', $email);
		$this->db->where('Password', md5($password));
		
		$query = $this->db->get('Accounts');
		
		if($query->num_rows() == 1)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function insert($new_account)
	{
		$this->db->insert('Accounts', $new_account);
	}
	
	public function get_account_info($id, $email)
	{
		$this->db->where('AccountId', $id);
		$this->db->where('Email', $email);
		
		$query = $this->db->get('Accounts');
		$data = $query->result_array();
		
		return $data[0];
	}
	
	public function get_account_info_by_email($email)
	{
		$this->db->where('Email', $email);
		
		$query = $this->db->get('Accounts');
		$data = $query->result_array();
		
		if($query->num_rows() == 1)
		{
			return $data[0];
		}else{
			return false;
		}
	}
	
}