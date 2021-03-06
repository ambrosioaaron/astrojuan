<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function tips_review()
	{	
		if($this->validate_login())
		{
			$this->load->model('model_tips');
			
			$data['title'] = "Tips Review";

			$data['tips'] = array_reverse($this->model_tips->get_all());
			
			$this->masterpage->setMasterPage ('astrojuan_master');
			$this->masterpage->addContentPage ('view_admin_tips_review', 'content', $data);
	
			$this->masterpage->show($data);
		}else{
			redirect("/", "refresh");
		}
	}
	
	public function events_review()
	{	
		if($this->validate_login())
		{
			$this->load->model('model_events');
			
			$data['title'] = "Events Review";

			$data['events'] = array_reverse($this->model_events->get_all());
			
			$this->masterpage->setMasterPage ('astrojuan_master');
			$this->masterpage->addContentPage ('view_admin_events_review', 'content', $data);
	
			$this->masterpage->show($data);
		}else{
			redirect("/", "refresh");
		}
	}
	
	public function article_review()
	{	
		if($this->validate_login())
		{
			$this->load->model('model_articles');
			
			$data['title'] = "Articles Review";

			$data['articles'] = array_reverse($this->model_articles->get_all());
			
			$this->masterpage->setMasterPage ('astrojuan_master');
			$this->masterpage->addContentPage ('view_admin_article_review', 'content', $data);
	
			$this->masterpage->show($data);
		}else{
			redirect("/", "refresh");
		}
	}
	
	public function tip_enable()
	{
		if($this->validate_login())
		{		
			$this->load->model('model_tips');
			
			$this->model_tips->tip_enable($this->input->get('tipid'));
			
			echo 'Tip Enabled';
		}else{
			echo 'Transaction Failed';
		}
	}
	
	public function event_disable()
	{
		if($this->validate_login())
		{
			$this->load->model('model_events');
			
			$this->model_events->event_disable($this->input->get('event_id'));
			
			echo 'Event Disabled';
		}else{
			echo "Transaction Failed";
		}
	}
	
	public function event_enable()
	{
		if($this->validate_login())
		{		
			$this->load->model('model_events');
			
			$this->model_events->event_enable($this->input->get('eventid'));
			
			echo 'Event Enabled';
		}else{
			echo 'Transaction Failed';
		}
	}
	
	public function tip_disable()
	{
		if($this->validate_login())
		{
			$this->load->model('model_tips');
			
			$this->model_tips->tip_disable($this->input->get('tip_id'));
			
			echo 'Tip Disabled';
		}else{
			echo "Transaction Failed";
		}
	}
	
	public function article_enable()
	{
		if($this->validate_login())
		{		
			$this->load->model('model_articles');
			
			$this->model_articles->article_enable($this->input->get('articleid'));
			
			echo 'Article Enabled';
		}else{
			echo 'Transaction Failed';
		}
	}
	
	public function article_disable()
	{
		if($this->validate_login())
		{
			$this->load->model('model_articles');
			
			$this->model_articles->article_disable($this->input->get('article_id'));
			
			echo 'Article Disabled';
		}else{
			echo "Transaction Failed";
		}
	}
	
	public function validate_login()
	{
		$this->load->model('model_accounts');
		
		$account_id = $this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE);
		$account_email = $this->input->cookie(md5('account_email' . $this->config->item('cookie_key')), TRUE);
			
		if(!empty($account_id) && !empty($account_email))
		{
			$account_info = $this->model_accounts->get_account_info($account_id,$account_email);
			if($account_info != false && $account_info['AccessCode'] == 1)
			{
				$cookie_account_id = array(
				'name'  => md5('account_id' . $this->config->item('cookie_key')),
				'value'  => $account_info['AccountId'],
				'expire' => '86500',
				);
				
				$this->input->set_cookie($cookie_account_id);	
				
				$cookie_account_email = array(
				'name'  => md5('account_email' . $this->config->item('cookie_key')),
				'value'  => $account_info['Email'],
				'expire' => '86500',
				);
				
				$data['access_code'] = $account_info['AccessCode'];
				
				$this->input->set_cookie($cookie_account_email);
				
				return true;
			}else{
				return false;
			}
		}
		else{
			return false;
		}
	}
}