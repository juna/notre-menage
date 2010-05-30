<?php

class Buyings extends Controller
{	
	function Buyings()
	{
		parent::Controller();
		
		$this->template->set('page_alias', 'buyings');
		$this->template->set('page_name', 'Einkäufe');
	}
	
	function index()
	{
		$this->template->set_block('sidebar', 'content/buyings/_sidebar');
		
		$buyings = new Buying();
		$this->template->set('buyings', $buyings->get());
		
		$this->template->current_view = 'content/buyings/home';
		$this->template->render();
	}
	
	function create()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('store', 'Laden', 'required');
		$this->form_validation->set_rules('day', 'Tag', 'required');
		$this->form_validation->set_rules('month', 'Monat', 'required');
		$this->form_validation->set_rules('year', 'Jahr', 'required');

		if($this->form_validation->run() == TRUE)
		{
			$buying = new Buying();
			$store = new Store();
			$store->get_by_id($this->input->post('store'));
			
			$buying->date = mktime(0, 0, 0, $this->input->post('month'), $this->input->post('day'), $this->input->post('year'));
			$buying->save($store);

			redirect('buyings/edit/'.$buying->id);
		}
		else
		{
			$stores = new Store();
			$this->template->set('stores', $stores->get());

			$this->template->set('page_name', 'Einkauf erstellen');
			$this->template->current_view = 'content/buyings/create';
			$this->template->render();
		}
	}
	
	function edit($id)
	{
		$this->template->set('page_name', 'Einkauf bearbeiten');
		$this->template->set_block('sidebar', 'content/buyings/edit_sidebar');
		
		$buyings = new Buying();
		$this->template->set('buying', $buyings->get_by_id($id));
		
		$productcategory = new Productcategory();
		$this->template->set('productcategories', $productcategory->get());
		
		$this->template->current_view = 'content/buyings/edit';
		$this->template->render('layouts/fullscreen');
	}
	
		function addproduct($buying_id, $product_id)
		{
			$product_id = explode('_', $product_id);
		
			$data = array(
				'buying_id'		=> $buying_id,
				'product_id'	=> $product_id[1],
				'offprice'		=> 0
			);
			$this->db->insert('productpurchases', $data);
		
			$buyings = new Buying();
			$data['buying'] = $buyings->get_by_id($buying_id);
			$this->load->view('content/buyings/edit_list', $data);
		}
		
		function addproductac($buying_id)
		{
			$product_id = explode('_', $this->input->post('product'));
		
			$data = array(
				'buying_id'		=> $buying_id,
				'product_id'	=> $product_id[1],
				'offprice'		=> 0
			);
			$this->db->insert('productpurchases', $data);
		
			$buyings = new Buying();
			$data['buying'] = $buyings->get_by_id($buying_id);
			$this->load->view('content/buyings/edit_list', $data);
		}
		
		function deleteproduct($buying_id, $purchase_id)
		{
			$purchase_id = explode('_', $purchase_id);
			
			$this->db->where('id', $purchase_id[1]);
			$this->db->delete('productpurchases');
		
			$buyings = new Buying();
			$data['buying'] = $buyings->get_by_id($buying_id);
			$this->load->view('content/buyings/edit_list', $data);
		}
		
		function saveproduct($buying_id, $purchase_id)
		{
			$purchase_id = explode('_', $purchase_id);
			
			$price = str_replace(array(','), array('.'), $_POST['price']);
			
			$data = array('offprice' => $price);
			$this->db->where('id', $purchase_id[1]);
			$this->db->update('productpurchases', $data);
		
			$productpurchase = new Productpurchase();
			$productpurchase->where_related_buying('id', $buying_id);
			$productpurchase->select_sum('offprice')->get();
		
			echo $productpurchase->offprice;
		}
}