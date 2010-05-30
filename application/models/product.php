<?php

class Product extends DataMapper
{
	var $has_one = array('productcategory');
	var $has_many = array('productpurchase');

	var $default_order_by = array('title' => 'asc');
	
	// --------------------------------------------------------------------
	/**
	 * Constructor: calls parent constructor
	 */
    function __construct($id = NULL)
	{
		parent::__construct($id);
    }
}