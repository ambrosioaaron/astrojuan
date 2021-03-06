<?php

class Model_articles extends CI_Model
{
	public function get_articles()
	{
		$query = $this->db
		->select('ar.ArticleId,ar.ArticleTitle,ar.ArticleShortDesc,ar.ArticleContent,ar.ContentStatus,ar.CreatedBy,ar.CreateDate,ar.LastUpdateBy,ar.LastUpdate,a.DisplayName')
		->from('Articles AS ar')
		->join('Accounts AS a', 'ar.CreatedBy = a.AccountId', 'left')
		->where('ar.ContentStatus', 2)
		->get();
		
		$data=$query->result_array();
		
		return $data;
	}
	
	public function get_account_articles($account_id)
	{
		$query = $this->db
		->select('ar.ArticleId,ar.ArticleTitle,ar.ArticleShortDesc,ar.ArticleContent,ar.ContentStatus,ar.CreatedBy,ar.CreateDate,ar.LastUpdateBy,ar.LastUpdate,cs.Title AS `Status`')
		->from('Articles AS ar')
		->join('ContentStatus AS cs', 'ar.ContentStatus = cs.ContentStatusId', 'left')
		->where('ar.CreatedBy', $account_id)
		->where_in('ar.ContentStatus', array('1','2'))
		->get();
		
		$data=$query->result_array();
		
		return $data;
	}
	
	public function get_article($article_id)
	{
		$query = $this->db
		->select('ar.ArticleId,ar.ArticleTitle,ar.ArticleShortDesc,ar.ArticleContent,ar.ContentStatus,ar.CreatedBy,ar.CreateDate,ar.LastUpdateBy,ar.LastUpdate, a.DisplayName')
		->from('Articles AS ar')
		->join('Accounts AS a', 'ar.CreatedBy = a.AccountId', 'left')
		->where('ar.ArticleId', $article_id)
		->get();
		
		$data=$query->result_array();
		
		return $data[0];
	}
	
	public function get_all()
	{
		$query = $this->db
		->select('ar.ArticleId,ar.ArticleTitle,ar.ArticleShortDesc,ar.ArticleContent,ar.ContentStatus,ar.CreatedBy,ar.CreateDate,ar.LastUpdateBy,ar.LastUpdate,a.DisplayName,cs.Title AS `Status`')
		->from('Articles AS ar')
		->join('Accounts AS a', 'ar.CreatedBy = a.AccountId', 'left')
		->join('ContentStatus AS cs', 'ar.ContentStatus = cs.ContentStatusId', 'left')
		->get();
		
		$data=$query->result_array();
		
		return $data;
	}
	
	public function article_enable($article_id)
	{
		$data = array('ContentStatus'=>2);
		$this->db->where('ArticleId',$article_id);
		$this->db->update('Articles', $data);
	}
	
	public function article_disable($article_id)
	{
		$data = array('ContentStatus'=>3);
		$this->db->where('ArticleId',$article_id);
		$this->db->update('Articles', $data);
	}
	
	public function insert($new_article)
	{
		$this->db->insert('Articles', $new_article);
	}
	
	public function update($tip)
	{
		$this->db->update('Articles', $tip, "ArticleId = ".$tip['ArticleId']);
	}
}