<?php

namespace CrazyCodr\Data\Filter;

/**
* This exception is raised when an operation tries to access a filter that doesn't exist in a filter container
*
* @uses     \OutOfRangeException
*
* @category Exceptions
* @package  CrazyCodr/Data-Filter
* @author   CrazyOne@CrazyCoders
* @license  MIT
* @link     crazycoders.net  
*/
class FilterNotFoundException extends \OutOfRangeException
{

    /**
     * Builds a new exception
     * 
     * @param mixed $name Name of the intended filter that failed
     *
     * @access public
     */
	public function __construct($name)
	{
		parent::__construct('Filter named "'.htmlentities($name).'" not found in current filter container');
	}

}