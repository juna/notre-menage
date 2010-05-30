<?php

class Products extends Controller
{	
	function Products()
	{
		parent::Controller();
		
		$this->template->set('page_alias', 'products');
		$this->template->set('page_name', 'Produkte');
		$this->template->set_block('sidebar', 'content/products/_sidebar');
	}
	
	function index()
	{
		$productcategory = new Productcategory();
		$this->template->set('productcategories', $productcategory->get());
		
		$this->template->current_view = 'content/products/home';
		$this->template->render();
	}
	
	function create()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Name', 'required');
		$this->form_validation->set_rules('productcategory', 'Kategorie', 'required');
		
		if($this->form_validation->run() == TRUE)
		{
			$product = new Product();
			$productcategory = new Productcategory();
			$productcategory->get_by_id($this->input->post('productcategory'));
			
			$product->title = $this->input->post('title');
			$product->save($productcategory);

			redirect('products');
		}
		else
		{
			$productcategory = new Productcategory();
			$this->template->set('productcategories', $productcategory->get());

			$this->template->set('page_name', 'Produkt erstellen');
			$this->template->current_view = 'content/products/create';
			$this->template->render();
		}
	}
}