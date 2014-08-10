<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tips extends CI_Controller
{
	public function index()
	{
		$this->load->model('model_tips');
		
		$data['title'] = "Tips";
		
		$data['tips'] = array_reverse($this->model_tips->get_tips());

		$this->masterpage->setMasterPage ('astrojuan_master');
        $this->masterpage->addContentPage ('view_tips', 'content', $data);

        $this->masterpage->show($data);
	}
}