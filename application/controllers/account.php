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
		$this->load->helper('captcha');
		
		$original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $captcha = substr(str_shuffle($original_string), 0, 8);
		$vals = array(
			'word'	 => $captcha,
			'img_path'	 => './captcha/',
			'img_url'	 => base_url().'captcha/',
			'font_path'	 => './content/font/HoboStd.otf',
			'img_width'	 => '150',
			'img_height' => 50,
			'expiration' => 1800
			);
		
		$cap = create_captcha($vals);
		$data['captcha'] = $cap['image'];
		
		$cookie_captcha = array(
		'name'  => md5('captcha' . $this->config->item('cookie_key')),
		'value'  => md5($captcha . $this->config->item('cookie_key')),
		'expire' => '1800',
		);
		
		$this->input->set_cookie($cookie_captcha);
				
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
		
		$data['captchaAttr'] = array(
			'type'=>'text',
			'class'=>'form-control',
			'id'=>'captcha_input',
			'name'=>'captcha_input',
			'placeholder'=>'Captcha', 
			'data-toggle'=>'popover',
			'data-trigger'=>'focus',
			'data-placement'=>'right',
			'data-content'=>'Type the text above'
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
			$this->form_validation->set_message('alpha_numeric', '%s may only contain alpha-numeric characters');
			$this->form_validation->set_message('validate_captcha', 'Wrong %s code');
			
			$this->form_validation->set_rules('display_name', 'Display Name', 'trim|xss_clean|alpha_numeric|required|min_length[6]|max_length[20]|is_unique[Accounts.DisplayName]');
			$this->form_validation->set_rules('user_password', 'Password', 'required|min_length[6]|max_length[20]|required|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');
			$this->form_validation->set_rules('email_address', 'Email', 'trim|xss_clean|required|valid_email|is_unique[Accounts.Email]');
			$this->form_validation->set_rules('captcha_input', 'Captcha', 'trim|xss_clean|required|callback_validate_captcha');
			
			$data['displayNameAttr']['value'] = $this->input->post('display_name');
			$data['emailAddressAttr']['value'] = $this->input->post('email_address');
			
			if($this->form_validation->run())
			{
				$new_account = array(
					'DisplayName'=>$this->input->post('display_name'),
					'Email'=>$this->input->post('email_address'),
					'Password'=>$this->input->post('user_password')
				);
				
				$this->model_accounts->insert($new_account);
				
                echo "success";
            }
            else{
                $data['validation_errors'] = array(
					'confirm_password'=>form_error('confirm_password'),
					'user_password'=>form_error('user_password'),
					'email_address'=>form_error('email_address'),
					'display_name'=>form_error('display_name'),
					'captcha_input'=>form_error('captcha_input')
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
	
	public function logout()
	{
		delete_cookie(md5('account_id' . $this->config->item('cookie_key')));
		delete_cookie(md5('account_email' . $this->config->item('cookie_key')));
		
		$data['title'] = "Home";
		
		$this->masterpage->setMasterPage ('astrojuan_master');
        $this->masterpage->addContentPage ('view_home', 'content');

        $this->masterpage->show($data);
	}
	
	public function test()
	{
		$this->load->helper('captcha');
		$original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $captcha = substr(str_shuffle($original_string), 0, 8);
		$vals = array(
			'word'	 => $captcha,
			'img_path'	 => './captcha/',
			'img_url'	 => 'http://localhost:88/captcha/',
			'font_path'	 => './content/font/Hobo.ttf',
			'img_width'	 => '150',
			'img_height' => 50,
			'expiration' => 1800
			);
		
		$cap = create_captcha($vals);
		echo $cap['image'];
	}
	
	public function validate_captcha()
	{
		if(md5($this->input->post('captcha_input') . $this->config->item('cookie_key')) != $this->input->cookie(md5('captcha' . $this->config->item('cookie_key')), TRUE))
		{
			return false;
		}else
		{
			return true;
		}
	}
}