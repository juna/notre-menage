<?php

class Store extends DataMapper
{
	var $has_one = array();
	var $has_many = array('buying');

	
	// --------------------------------------------------------------------
	/**
	 * Constructor: calls parent constructor
	 */
    function __construct($id = NULL)
	{
		parent::__construct($id);
    }
}