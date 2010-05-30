<?php

class Articles extends Controller {

	function Articles()
	{
		parent::Controller();
		
		$this->template->set('page_alias', 'articles');
		$this->template->set_block('sidebar', 'content/articles/_sidebar');
	}
	
	function index()
	{
		$articlecategories = new Articlecategory();
		$this->template->set('res_articlecategories', $articlecategories->get());
		
		$articles = new Article();
		$this->template->set('res_articles', $articles->get());
		
		$this->template->set('page_name', 'Artikel');
		$this->template->current_view = 'content/articles/home';
		$this->template->render();
	}
	
	/*
	 * Articles
	 */
	function article_create()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Titel', 'required|callback_article_unique_title');		
		$this->form_validation->set_rules('intro', 'Einführungstext', 'required');
		$this->form_validation->set_rules('category[]', 'Kategorie', 'required');
		$this->form_validation->set_rules('body', 'Text', 'required');

		if($this->form_validation->run() == TRUE)
		{
			$articlecategories = new Articlecategory();
			$articlecategories->where_in('id', $this->input->post('category'))->get();

			$article = new Article();
			$article->title = $this->input->post('title');
			$article->alias = $this->_title_to_alias($article->title);
			$article->intro = $this->input->post('intro');
			$article->body = $this->input->post('body');
			$article->state = 1;
			$article->save($articlecategories->all);
			
			redirect('artikel');
		}
		else
		{
			$articlecategories = new Articlecategory();
			$this->template->set('res_articlecategories', $articlecategories->get());
		
			$this->template->set_block('sidebar', 'content/articles/_sidebar_create');
			
			$this->template->set('page_name', 'Artikel schreiben');
			$this->template->current_view = 'content/articles/create';
			$this->template->render();
		}
	}
	
		function article_unique_title($str)
		{
			$this->form_validation->set_message('article_unique_title', 'Es existier bereits ein Artikel mit diesem Titel.');
			
			$article = new Article();
			$article->where('title', $str)->get();
			if($article->exists()) return FALSE;
			
		 	return TRUE;
		}
	
	/*
	 * Article categories
	 */
	function category_create()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Titel', 'required|callback_category_unique_title');

		if($this->form_validation->run() == TRUE)
		{
			$articlecategory = new Articlecategory();
			$articlecategory->title = $this->input->post('title');
			$articlecategory->alias = $this->_title_to_alias($articlecategory->title);
			$articlecategory->save();
			
			redirect('artikel');
		}
		else
		{
			$this->template->set_block('sidebar', 'content/articles/categories/_sidebar_create');
			
			$this->template->set('page_name', 'Artikelkategorie anlegen');
			$this->template->current_view = 'content/articles/categories/create';
			$this->template->render();
		}
	}
	
		function category_unique_title($str)
		{
			$this->form_validation->set_message('category_unique_title', 'Es existier bereits eine Kategorie mit diesem Titel.');
			
			$articlecategory = new Articlecategory();
			$articlecategory->where('title', $str)->get();
			if($articlecategory->exists()) return FALSE;
			
		 	return TRUE;
		}
	
	/*
	 * Helpers
	 */
	function _title_to_alias($title)
	{
		$alias = $title;
		
		$from = Array("/ä/","/ö/","/ü/","/Ä/","/Ö/","/Ü/","/ß/");
		$to = Array("ae","oe","ue","Ae","Oe","Ue","ss");
		$alias = preg_replace($from, $to, $alias);
		
		return url_title($alias, 'dash', TRUE);
	}
}