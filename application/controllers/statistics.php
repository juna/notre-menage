<?php

class Statistics extends Controller
{	
	function Statistics()
	{
		parent::Controller();
		
		$this->template->set('page_alias', 'statistics');
		$this->template->set('page_name', 'Statistik');
		$this->template->set_block('sidebar', 'content/statistics/_sidebar');
	}
	
	function index()
	{
		$buyings = new Buying();
		$this->template->set('buyings', $buyings->get());
	
		$this->template->current_view = 'content/statistics/home';
		$this->template->render();
	}
}