<?php

class Application extends Controller
{	
	function Application()
	{
		parent::Controller();
		
		$this->template->set('page_alias', 'application');
		
		$this->template->set('page_name', 'Startseite');
	}
	
	function index()
	{
		$this->template->current_view = 'content/home';
		$this->template->render();
	}
}