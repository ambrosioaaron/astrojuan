<?php

class Model_tips extends CI_Model
{
	public function get_tips()
	{
		$query = $this->db
		->select('t.TipId,t.TipContent,t.ContentStatus,t.CreatedBy,t.CreateDate,t.LastUpdateBy,t.LastUpdate,a.DisplayName')
		->from('Tips AS t')
		->join('Accounts AS a', 't.CreatedBy = a.AccountId', 'left')
		->where('t.ContentStatus', 2)
		->get();
		
		$data=$query->result_array();
		
		return $data;
	}
	
	public function get_account_tips($account_id)
	{
		$query = $this->db
		->select('t.TipId,t.TipContent,t.ContentStatus,t.CreatedBy,t.CreateDate,t.LastUpdateBy,t.LastUpdate,cs.Title AS `Status`')
		->from('Tips AS t')
		->join('ContentStatus AS cs', 't.ContentStatus = cs.ContentStatusId', 'left')
		->where('t.CreatedBy', $account_id)
		->where_in('t.ContentStatus',array('1','2'))
		->get();
		
		$data=$query->result_array();
		
		return $data;
	}
	
	public function get_all()
	{
		$query = $this->db
		->select('t.TipId,t.TipContent,t.ContentStatus,t.CreatedBy,t.CreateDate,t.LastUpdateBy,t.LastUpdate,a.DisplayName,cs.Title AS `Status`')
		->from('Tips AS t')
		->join('Accounts AS a', 't.CreatedBy = a.AccountId', 'left')
		->join('ContentStatus AS cs', 't.ContentStatus = cs.ContentStatusId', 'left')
		->get();
		
		$data=$query->result_array();
		
		return $data;
	}
	
	public function tip_enable($tip_id)
	{
		$data = array('ContentStatus'=>2);
		$this->db->where('TipId',$tip_id);
		$this->db->update('Tips', $data);
	}
	
	public function tip_disable($tip_id)
	{
		$data = array('ContentStatus'=>3);
		$this->db->where('TipId',$tip_id);
		$this->db->update('Tips', $data);
	}
	
	public function insert($new_tip)
	{
		$this->db->insert('Tips', $new_tip);
	}
	
	public function update($tip)
	{
		$this->db->update('Tips', $tip, "TipId = ".$tip['TipId']);
	}
}