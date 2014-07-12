<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller
{
	public function index()
	{
		$data['title'] = "Events";
		
		$this->masterpage->setMasterPage ('astrojuan_master');
        $this->masterpage->addContentPage ('view_events', 'content');

        $this->masterpage->show($data);
	}
}