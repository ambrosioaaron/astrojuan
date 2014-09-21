<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends CI_Controller
{
	public function index()
	{
		$this->load->model('model_articles');
		
		$data['title'] = "Articles";
		
		$data['articles'] = array_reverse($this->model_articles->get_articles());
		
		$this->masterpage->setMasterPage ('astrojuan_master');
        $this->masterpage->addContentPage ('view_articles', 'content', $data);

        $this->masterpage->show($data);
	}
	
	public function read()
	{
		$this->load->helper('security');
		$this->load->helper('url');
		$this->load->model('model_articles');
		
		if(!empty(xss_clean($_GET['articleid'])))
		{
			$article = $this->model_articles->get_article(xss_clean($_GET['articleid']));
			$data['title'] = $article['ArticleTitle'];
			$data['article'] = $article;
			
			if(empty($data['article']))
			{
				redirect('/errors/notfound', 'refresh');
			}
		}else
		{
			redirect('/errors/notfound', 'refresh');
		}
		
		$this->masterpage->setMasterPage ('astrojuan_master');
        $this->masterpage->addContentPage ('view_article_read', 'content', $data);

        $this->masterpage->show($data);
	}
}