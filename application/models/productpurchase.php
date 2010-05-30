<?php

class Productpurchase extends DataMapper
{
	var $model = 'productpurchase';
	var $table = 'productpurchases';

	var $has_one = array('buying', 'product');
	var $has_many = array();

	var $default_order_by = array('id' => 'asc');
	
	// --------------------------------------------------------------------
	/**
	 * Constructor: calls parent constructor
	 */
    function __construct($id = NULL)
	{
		parent::__construct($id);
    }
}