<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Controller
{
	public function index()
	{
		$data['title'] = "Articles";
		
		$this->masterpage->setMasterPage ('juanpot_master');
        $this->masterpage->addContentPage ('view_articles', 'content');

        $this->masterpage->show($data);
	}
}