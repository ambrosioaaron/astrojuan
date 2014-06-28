<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller
{
	public function index()
	{
		$data['title'] = "About";
		
		$this->masterpage->setMasterPage ('juanpot_master');
        $this->masterpage->addContentPage ('view_about', 'content');

        $this->masterpage->show($data);
	}
}