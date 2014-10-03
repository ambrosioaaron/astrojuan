<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller
{
	public function index()
	{
		$this->load->model('model_events');
		
		$data['title'] = "Events";
		
		$data['events'] = array_reverse($this->model_events->get_events());

		$this->masterpage->setMasterPage ('astrojuan_master');
        $this->masterpage->addContentPage ('view_events', 'content', $data);

        $this->masterpage->show($data);
	}
}