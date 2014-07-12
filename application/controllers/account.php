<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller
{
	public function index()
	{
		$data['title'] = "Account";
		
		$this->masterpage->setMasterPage ('astrojuan_master');
        $this->masterpage->addContentPage ('view_about', 'content', $data);

        $this->masterpage->show($data);
	}
	
	public function login()
	{
		$this->load->library('form_validation');
		$this->load->model('model_accounts');
		
		$data['formAttr'] = array('class' => 'dropdown-menu', 'id' => 'frmLogin');
		
		$data['emailAttr'] = array(
                'class' => 'form-control input-sm',
                'data-val' => 'true',
                'data-val-required' => 'Email is required.',
                'id' => 'email',
                'name' => 'email',
                'placeholder' => 'Email', 
                'type' => 'text',
                'value' => '');
		
		$data['passwordAttr'] = array(
                'class' => 'form-control input-sm',
                'data-val' => 'true',
                'data-val-required' => 'Password is required.',
                'id' => 'password',
                'name' => 'password',
                'placeholder' => '********', 
                'type' => 'password',
                'value' => '');
		
		if($this->input->post())
		{
			$data['validLogin'] = $this->model_accounts->validate_login($this->input->post('email'),$this->input->post('password'));
		
			$this->form_validation->set_rules('email','Email','required|trim|xss_clean');
			$this->form_validation->set_rules('password','Password','required|md5|trim');
			
			sleep(1);
			
			if($this->form_validation->run() && $data['validLogin'])
			{
				$account_info = $this->model_accounts->get_account_info_by_email($this->input->post('email'));
				
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
				
				$this->input->set_cookie($cookie_account_email);
				
				$this->load->view('view_login', $data);
				
			}else
			{
				$this->load->view('view_login', $data);
			}
		}else
		{
			$account_id = $this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE);
			$account_email = $this->input->cookie(md5('account_email' . $this->config->item('cookie_key')), TRUE);
			
			if(!empty($account_id) && !empty($account_email))
			{
				$account_info = $this->model_accounts->get_account_info($account_id,$account_email);
				
				if($account_info != false)
				{
					$data['validLogin'] = $account_info;
				}
			}
			
			$this->load->view('view_login', $data);
		}
		
	}
	
	public function register()
	{
		$data['title'] = "Register";
		
		$this->masterpage->setMasterPage ('astrojuan_master');
        $this->masterpage->addContentPage ('view_register', 'content', $data);

        $this->masterpage->show($data);
	}
}