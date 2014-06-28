<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller
{
	public function index()
	{
		$data['title'] = "Error";
		
		$this->masterpage->setMasterPage ('juanpot_master');
        $this->masterpage->addContentPage ('view_error', 'content');

        $this->masterpage->show($data);
	}
	
	public function notfound()
	{
		$data['title'] = "Error 404";
		
		$this->masterpage->setMasterPage ('juanpot_master');
        $this->masterpage->addContentPage ('view_error_notfound', 'content');

        $this->masterpage->show($data);
	}
}