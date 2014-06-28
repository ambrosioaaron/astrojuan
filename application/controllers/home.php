<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function index()
	{
		$data['title'] = "Home";
		
		$this->masterpage->setMasterPage ('juanpot_master');
        $this->masterpage->addContentPage ('view_home', 'content');

        $this->masterpage->show($data);
	}
}