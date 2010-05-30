<?php

class Productcategory extends DataMapper
{
	var $has_one = array();
	var $has_many = array('product');

	
	// --------------------------------------------------------------------
	/**
	 * Constructor: calls parent constructor
	 */
    function __construct($id = NULL)
	{
		parent::__construct($id);
    }
}