<?php

class Buying extends DataMapper
{
	var $has_one = array('store');
	var $has_many = array('productpurchase');

	var $default_order_by = array('date' => 'desc');
	
	// --------------------------------------------------------------------
	/**
	 * Constructor: calls parent constructor
	 */
    function __construct($id = NULL)
	{
		parent::__construct($id);
    }
}