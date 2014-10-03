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
				$data['display_name'] = $account_info['DisplayName'];
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
					$data['display_name'] = $account_info['DisplayName'];
					$data['access_code'] = $account_info['AccessCode'];
				}
			}
			
			$this->load->view('view_login', $data);
		}
		
	}
	
	public function register()
	{
		$this->load->helper('captcha');
		
		$original_string = array_merge(range(0,9), range('A', 'Z'));
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
		
		$data['hideLogin'] = "test";
		
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
					'Password'=>md5($this->input->post('user_password')),
					'CreateDate'=>date('Y-m-d H:i:s'),
					'AccessCode'=>2
				);
				
				$data['hideLogin'] = null;
				
				$this->model_accounts->insert($new_account);
				
                $this->masterpage->setMasterPage ('astrojuan_master');
				$this->masterpage->addContentPage ('view_register_success', 'content', $data);
		
				$this->masterpage->show($data);
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
			if(!$this->validate_login())
			{
				$this->masterpage->setMasterPage ('astrojuan_master');
				$this->masterpage->addContentPage ('view_register', 'content', $data);
		
				$this->masterpage->show($data);
			}else{
				redirect('/','refresh');
			}
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
	
	public function tips()
	{
		if($this->validate_login())
		{
			$this->load->helper('captcha');
		
			$original_string = array_merge(range(0,9), range('A', 'Z'));
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
			
			$data['title'] = "Tips";

			$data['form_attribute'] = array(
				'role'=>'form',
				'class'=>'form-horizontal',
				'id'=>'frmPostTip',
				'name'=>'frmPostTip',
				'method'=>'post',
			);
			
			$data['tip_id'] = array(
				'class'=>'form-control',
				'id'=>'tip_id',
				'name'=>'tip_id',
				'type'=>'hidden',
				'value'=>'0'
			);
			
			$data['tip_content'] = array(
				'class'=>'form-control',
				'id'=>'tip_content',
				'name'=>'tip_content',
				'placeholder'=>'Write here...',
				'data-toggle'=>'popover',
				'data-trigger'=>'focus',
				'data-placement'=>'right',
				'rows'=>'10',
				'maxlength'=>'420'
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
			
			$data['btn_submit'] = array(
				'id'=>'tipSubmit',
				'class'=>'btn btn-success btn-sm',
				'name'=>'tipSubmit',
				'style'=>'width: 100%;',
				'value'=>'Submit'
			);
			
			$this->load->model('model_tips');
			
			if($this->input->post())
			{	
				$this->load->library('form_validation');
				
				$this->form_validation->set_message('required', 'You cannot post blank.');
				$this->form_validation->set_message('max_length', '%s is too long. Maximum of 420 characters.');
				$this->form_validation->set_message('validate_captcha', 'Wrong %s code');
				
				$this->form_validation->set_rules('tip_content','Tip Content','required|trim|max_length[420]|xss_clean');
				$this->form_validation->set_rules('captcha_input', 'Captcha', 'trim|xss_clean|callback_validate_captcha');
				
				if($this->form_validation->run())
				{	
					$new_tip = array(
						'TipContent'=>$this->input->post('tip_content'),
						'ContentStatus'=>1,
						'CreatedBy'=>$this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE),
						'CreateDate'=>date('Y-m-d H:i:s'),
						'LastUpdateBy'=>$this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE)
					);
					
					if((int)$this->input->post('tip_id') > 0)
					{
						$new_tip = array(
							'TipContent'=>$this->input->post('tip_content'),
							'LastUpdateBy'=>$this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE),
							'LastUpdate'=>date('Y-m-d H:i:s'),
							'TipId'=>$this->input->post('tip_id')
						);
						
						$this->model_tips->update($new_tip);
					}else{
						$this->model_tips->insert($new_tip);
					}
					
				}else{
					$data['tip_id']['value'] = $this->input->post('tip_id');
					$data['tip_content']['value'] = $this->input->post('tip_content');
					$data['validation_errors'] = array(
						'tip_content'=>form_error('tip_content'),
						'captcha_input'=>form_error('captcha_input'),
					);
				}
			}
			
			$data['tips'] = array_reverse($this->model_tips->get_account_tips($this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE)));
			
			$this->masterpage->setMasterPage ('astrojuan_master');
			$this->masterpage->addContentPage ('view_account_tips', 'content', $data);
	
			$this->masterpage->show($data);
		}else{
			redirect('/','refresh');
		}
	}
	
	public function events()
	{
		if($this->validate_login())
		{
			$this->load->helper('captcha');
		
			$original_string = array_merge(range(0,9), range('A', 'Z'));
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
			
			$data['title'] = "Events";

			$data['form_attribute'] = array(
				'role'=>'form',
				'class'=>'form-horizontal',
				'id'=>'frmPostEvent',
				'name'=>'frmPostEvent',
				'method'=>'post',
			);
			
			$data['event_id'] = array(
				'class'=>'form-control',
				'id'=>'event_id',
				'name'=>'event_id',
				'type'=>'hidden',
				'value'=>'0'
			);
			
			$data['event_title'] = array(
				'id'=>'event_title',
				'name'=>'event_title',
				'placeholder'=>'Event title',
				'class'=>'form-control',
				'style'=>'min-width: 85%;'
			);
			
			$data['event_banner'] = array(
				'class'=>'form-control',
				'id'=>'event_banner',
				'name'=>'event_banner',
				'placeholder'=>'Event banner URL',
				'data-toggle'=>'popover',
				'data-trigger'=>'focus',
				'data-placement'=>'right',
				'rows'=>'5',
				'maxlength'=>'420'
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
			
			$data['btn_submit'] = array(
				'id'=>'eventSubmit',
				'class'=>'btn btn-success btn-sm',
				'name'=>'eventSubmit',
				'style'=>'width: 100%;',
				'value'=>'Submit'
			);
			
			$this->load->model('model_events');
			
			if($this->input->post())
			{	
				$this->load->library('form_validation');
				
				$this->form_validation->set_message('required', 'You cannot post with blank %s');
				$this->form_validation->set_message('max_length', '%s is too long. Maximum of 420 characters.');
				$this->form_validation->set_message('validate_captcha', 'Wrong %s code');
				
				$this->form_validation->set_rules('event_title','Event Title','required|trim|max_length[420]|xss_clean');
				$this->form_validation->set_rules('event_banner','Event Banner','required|trim|max_length[420]|xss_clean');
				$this->form_validation->set_rules('captcha_input', 'Captcha', 'trim|xss_clean|callback_validate_captcha');
				
				if($this->form_validation->run())
				{	
					$new_event = array(
						'EventTitle'=>$this->input->post('event_title'),
						'EventBannerURL'=>$this->input->post('event_banner'),
						'ContentStatus'=>1,
						'CreatedBy'=>$this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE),
						'CreateDate'=>date('Y-m-d H:i:s'),
						'LastUpdateBy'=>$this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE)
					);
					
					if((int)$this->input->post('event_id') > 0)
					{
						$new_event = array(
							'EventTitle'=>$this->input->post('event_title'),
							'EventContent'=>$this->input->post('event_banner'),
							'LastUpdateBy'=>$this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE),
							'LastUpdate'=>date('Y-m-d H:i:s'),
							'EventId'=>$this->input->post('event_id')
						);
						
						$this->model_events->update($new_event);
					}else{
						$this->model_events->insert($new_event);
					}
					
				}else{
					$data['event_id']['value'] = $this->input->post('event_id');
					$data['event_title']['value'] = $this->input->post('event_title');
					$data['event_banner']['value'] = $this->input->post('event_banner');
					$data['validation_errors'] = array(
						'event_title'=>form_error('event_title'),
						'event_banner'=>form_error('event_banner'),
						'captcha_input'=>form_error('captcha_input'),
					);
				}
			}
			
			$data['events'] = array_reverse($this->model_events->get_account_events($this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE)));
			
			$this->masterpage->setMasterPage ('astrojuan_master');
			$this->masterpage->addContentPage ('view_account_events', 'content', $data);
	
			$this->masterpage->show($data);
		}else{
			redirect('/','refresh');
		}
	}
	
	public function articles()
	{
		if($this->validate_login())
		{
			$this->load->helper('captcha');
		
			$original_string = array_merge(range(0,9), range('A', 'Z'));
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
			
			$data['title'] = "Articles";

			$data['form_attribute'] = array(
				'role'=>'form',
				'class'=>'form-horizontal',
				'id'=>'frmPostArticle',
				'name'=>'frmPostArticle',
				'method'=>'post',
			);
			
			$data['article_id'] = array(
				'id'=>'article_id',
				'name'=>'article_id',
				'type'=>'hidden',
				'value'=>'0'
			);
			
			$data['article_title'] = array(
				'class'=>'form-control',
				'placeholder'=>'Article Title',
				'id'=>'article_title',
				'name'=>'article_title',
				'style'=>'min-width: 100%;'
			);
			
			$data['article_desc'] = array(
				'class'=>'form-control',
				'placeholder'=>'Short Description',
				'id'=>'article_desc',
				'name'=>'article_desc',
				'style'=>'min-width: 100%;'
			);
			
			$data['article_content'] = array(
				
				'id'=>'article_content',
				'name'=>'article_content',
				'rows'=>'15',
				'cols'=>'100',
				'style'=>'width: 100%;'
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
			
			$data['btn_submit'] = array(
				'id'=>'article_submit',
				'class'=>'astro-article-submit btn btn-success',
				'name'=>'article_submit',
				'value'=>'Submit'
			);
			
			$this->load->model('model_articles');
			
			if($this->input->post())
			{	
				$this->load->library('form_validation');
				
				$this->form_validation->set_message('required', 'You cannot post blank.');
				$this->form_validation->set_message('max_length', '%s is too long');
				$this->form_validation->set_message('validate_captcha', 'Wrong %s code');
				
				$this->form_validation->set_rules('article_content','Article Content','required|trim|max_length[60000]|xss_clean');
				$this->form_validation->set_rules('article_title','Article Title','required|trim|max_length[420|xss_clean');
				$this->form_validation->set_rules('article_desc','Article Short Description','required|trim|max_length[420|xss_clean');
				$this->form_validation->set_rules('captcha_input', 'Captcha', 'trim|xss_clean|callback_validate_captcha');
				
				if($this->form_validation->run())
				{
					$new_article= array(
						'ArticleTitle'=>$this->input->post('article_title'),
						'ArticleContent'=>$this->input->post('article_content'),
						'ArticleShortDesc'=>$this->input->post('article_desc'),
						'ContentStatus'=>1,
						'CreatedBy'=>$this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE),
						'CreateDate'=>date('Y-m-d H:i:s'),
						'LastUpdateBy'=>$this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE)
					);
					
					if((int)$this->input->post('article_id') > 0)
					{
						$new_article = array(
							'ArticleContent'=>$this->input->post('article_content'),
							'LastUpdateBy'=>$this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE),
							'LastUpdate'=>date('Y-m-d H:i:s'),
							'ArticleId'=>$this->input->post('article_id')
						);
						
						$this->model_articles->update($new_article);
					}else{
						$this->model_articles->insert($new_article);
					}
					
				}else{
					$data['article_title']['value'] = $this->input->post('article_title');
					$data['article_desc']['value'] = $this->input->post('article_desc');
					$data['article_content']['value'] = html_entity_decode($this->input->post('article_content'));
					
					$data['validation_errors'] = array(
						'article_content'=>form_error('article_content'),
						'captcha_input'=>form_error('captcha_input')
					);
				}
			}
			
			$data['articles'] = array_reverse($this->model_articles->get_account_articles($this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE)));
			
			$this->masterpage->setMasterPage ('astrojuan_master');
			$this->masterpage->addContentPage ('view_account_article', 'content', $data);
	
			$this->masterpage->show($data);
		}else{
			redirect('/','refresh');
		}
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
	
	public function validate_login()
	{
		$this->load->model('model_accounts');
		
		$account_id = $this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE);
		$account_email = $this->input->cookie(md5('account_email' . $this->config->item('cookie_key')), TRUE);
			
		if(!empty($account_id) && !empty($account_email))
		{
			$account_info = $this->model_accounts->get_account_info($account_id,$account_email);
			if($account_info != false)
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
	
	public function article_edit()
	{
		if($this->validate_owner($this->input->get('article_owner_id')))
		{
			$this->load->model('model_articles');
			$article = $this->model_articles->get_article($this->input->get('article_id'));
			
			header('Content-Type: application/json');
    		echo json_encode( $article );
			
		}else{
			echo "Transaction Failed";
		}
	}
	
	public function tip_disable()
	{
		if($this->validate_owner($this->input->get('tip_owner_id')))
		{
			$this->load->model('model_tips');
			
			$this->model_tips->tip_disable($this->input->get('tip_id'));
			
			echo 'Tip Disabled';
		}else{
			echo "Transaction Failed";
		}
	}
	
	public function event_disable()
	{
		if($this->validate_owner($this->input->get('event_owner_id')))
		{
			$this->load->model('model_events');
			
			$this->model_events->event_disable($this->input->get('event_id'));
			
			echo 'Event Disabled';
		}else{
			echo "Transaction Failed";
		}
	}
	
	public function article_disable()
	{
		if($this->validate_owner($this->input->get('article_owner_id')))
		{
			$this->load->model('model_articles');
			
			$this->model_articles->article_disable($this->input->get('article_id'));
			
			echo 'Article Disabled';
		}else{
			echo "Transaction Failed";
		}
	}
	
	public function validate_owner($owner_id)
	{
		$this->load->model('model_accounts');
		
		$account_id = $this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE);
		$account_email = $this->input->cookie(md5('account_email' . $this->config->item('cookie_key')), TRUE);
			
		if(!empty($account_id) && !empty($account_email))
		{
			$account_info = $this->model_accounts->get_account_info($account_id,$account_email);
			return ($account_info['AccountId'] == $owner_id);
		}
	}
	
	public function current_account_info()
	{
		$this->load->model('model_accounts');
		
		$account_id = $this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE);
		$account_email = $this->input->cookie(md5('account_email' . $this->config->item('cookie_key')), TRUE);
		
		if($this->validate_login())
		{
			$account_info = $this->model_accounts->get_account_info($account_id,$account_email);
			return $account_info;
		}
		else{
			return false;
		}
	}
}