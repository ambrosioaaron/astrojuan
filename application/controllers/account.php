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
		
		$data['formAttr'] = array(
			'role'=>'form',
			'class'=>'form-horizontal',
			'id'=>'frmRegister',
			'name'=>'Register',
			'method'=>'post'
		);
		
		$data['displayNameAttr'] = array(
			'type'=>'text',
			'class'=>'form-control',
			'id'=>'display_name',
			'name'=>'display_name',
			'placeholder'=>'Display Name',
			'data-toggle'=>'popover',
			'data-trigger'=>'focus',
			'data-placement'=>'right',
			'data-content'=>'Letters and numbers only'
		);
		
		$data['emailAddressAttr'] = array(
			'type'=>'text',
			'class'=>'form-control',
			'id'=>'email_address',
			'name'=>'email_address',
			'placeholder'=>'Email Address', 
			'data-toggle'=>'popover',
			'data-trigger'=>'focus',
			'data-placement'=>'right',
			'data-content'=>'Enter a your email address'
		);
		
		$data['userPassswordAttr'] = array(
			'type'=>'password',
			'class'=>'form-control',
			'id'=>'user_password',
			'name'=>'user_password',
			'placeholder'=>'Password',
			'data-toggle'=>'popover',
			'data-trigger'=>'focus',
			'data-placement'=>'right',
			'data-content'=>'6 to 20 characters only'
		);
		
		$data['confirmPasswordAttr'] = array(
			'type'=>'password',
			'class'=>'form-control',
			'id'=>'confirm_password',
			'name'=>'confirm_password',
			'placeholder'=>'Confirm password', 
			'data-toggle'=>'popover',
			'data-trigger'=>'focus',
			'data-placement'=>'right',
			'data-content'=>'Re-type your password'
		);
		
		if($this->input->post())
        {
            $this->load->library('form_validation');
			$this->load->model('model_accounts');
			
			$this->form_validation->set_message('required', '%s is required');
			$this->form_validation->set_message('is_unique', '%s is already taken');
			$this->form_validation->set_message('matches', '%s did not match');
			$this->form_validation->set_message('min_length', '%s too short');
			$this->form_validation->set_message('max_length', '%s too long');
			$this->form_validation->set_message('alpha_numeric', '%s may only contain alpha-numeric characters.');
			
			$this->form_validation->set_rules('display_name', 'Display Name', 'alpha_numeric|required|min_length[6]|max_length[20]|is_unique[Accounts.DisplayName]');
			$this->form_validation->set_rules('user_password', 'Password', 'required|min_length[6]|max_length[20]|required|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');
			$this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|is_unique[Accounts.Email]');
			
			if($this->form_validation->run())
			{
                echo "success";
            }
            else{
                $data['validation_errors'] = array(
					'confirm_password'=>form_error('confirm_password'),
					'user_password'=>form_error('user_password'),
					'email_address'=>form_error('email_address'),
					'display_name'=>form_error('display_name')
					
				);
	
				$this->masterpage->setMasterPage ('astrojuan_master');
				$this->masterpage->addContentPage ('view_register', 'content', $data);
		
				$this->masterpage->show($data);
            }
        }
        else{
            $this->masterpage->setMasterPage ('astrojuan_master');
			$this->masterpage->addContentPage ('view_register', 'content', $data);
	
			$this->masterpage->show($data);
        }
	}
	
	public function add()
	{
		$this->load->library('form_validation');
		$this->load->model('model_accounts');
		
		$this->form_validation->set_rules('display_name', 'Display Name', 'alpha_numeric|required|min_length[6]|max_length[20]|is_unique[Accounts.DisplayName]');
		$this->form_validation->set_rules('user_password', 'Password', 'required|min_length[6]|max_length[20]|required|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|min_length[6]|max_length[20]|required');
		$this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|is_unique[Accounts.Email]');
		
		if($this->form_validation->run())
		{
			echo "success";
		}
	}
	
	public function logout()
	{
		delete_cookie(md5('account_id' . $this->config->item('cookie_key')));
		delete_cookie(md5('account_email' . $this->config->item('cookie_key')));
		
		$data['title'] = "Home";
		
		$this->masterpage->setMasterPage ('astrojuan_master');
        $this->masterpage->addContentPage ('view_home', 'content');

        $this->masterpage->show($data);
	}
}