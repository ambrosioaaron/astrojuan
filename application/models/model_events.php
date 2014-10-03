<?php

class Model_events extends CI_Model
{
	public function get_events()
	{
		$query = $this->db
		->select('e.EventId,e.EventTitle,e.EventBannerURL,e.ContentStatus,e.CreatedBy,e.CreateDate,e.LastUpdateBy,e.LastUpdate,a.DisplayName')
		->from('Events AS e')
		->join('Accounts AS a', 'e.CreatedBy = a.AccountId', 'left')
		->where('e.ContentStatus', 2)
		->get();
		
		$data=$query->result_array();
		
		return $data;
	}
	
	public function get_account_events($account_id)
	{
		$query = $this->db
		->select('e.EventId,e.EventTitle,e.EventBannerURL,e.ContentStatus,e.CreatedBy,e.CreateDate,e.LastUpdateBy,e.LastUpdate,cs.Title AS `Status`')
		->from('Events As e')
		->join('ContentStatus AS cs', 'e.ContentStatus = cs.ContentStatusId', 'left')
		->where('e.CreatedBy', $account_id)
		->where_in('e.ContentStatus',array('1','2'))
		->get();
		
		$data=$query->result_array();
		
		return $data;
	}
	
	public function get_all()
	{
		$query = $this->db
		->select('e.EventId,e.EventTitle,e.EventBannerURL,e.ContentStatus,e.CreatedBy,e.CreateDate,e.LastUpdateBy,e.LastUpdate,a.DisplayName,cs.Title AS `Status`')
		->from('Events As e')
		->join('Accounts AS a', 'e.CreatedBy = a.AccountId', 'left')
		->join('ContentStatus AS cs', 'e.ContentStatus = cs.ContentStatusId', 'left')
		->get();
		
		$data=$query->result_array();
		
		return $data;
	}
	
	public function event_enable($event_id)
	{
		$data = array('ContentStatus'=>2);
		$this->db->where('EventId',$event_id);
		$this->db->update('Events', $data);
	}
	
	public function event_disable($event_id)
	{
		$data = array('ContentStatus'=>3);
		$this->db->where('EventId',$event_id);
		$this->db->update('Events', $data);
	}
	
	public function insert($new_event)
	{
		$this->db->insert('Events', $new_event);
	}
	
	public function update($event)
	{
		$this->db->update('Events', $event, "EventId = ".$event['EventId']);
	}
}