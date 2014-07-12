<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller
{
	public function index()
	{	
		$data['title'] = "About";

		$this->masterpage->setMasterPage ('astrojuan_master');
        $this->masterpage->addContentPage ('view_about', 'content', $data);

        $this->masterpage->show($data);
	}
	
	public function test()
	{	
		echo $this->input->cookie(md5('account_id' . $this->config->item('cookie_key')), TRUE);
	}
}