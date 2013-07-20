<?php

namespace CrazyCoders\Data;

/**
* The filter class is an iterator iterator that features facilities to easily filter content of an enumerable
* using anonymous functions.
*
* @uses     iterator
*
* @abstract
*
* @category Base class
* @package  CrazyCoders/Data
* @author   CrazyOne@CrazyCoders
* @license  LGPLv2
* @link     crazycoders.net
*/
class Filter implements \iterator
{

    /**
     * Contains the datasource that will be iterated over applying filtering functions to it
     *
     * @var \Traversable
     *
     * @access protected
     */
    protected $datasource = NULL;

    /**
     * Contains the callbacks to execute when iterating data
     * Every callback must include a $data parameter to receive data and returns a boolean stating if the filter applies
     *
     * @var \Array
     *
     * @access protected
     */
    protected $filterCallbacks = array();

    /**
     * Builds the Filter using a specific datasource
     *
     * @param \Traversable $datasource Contains the datasource that will be iterated and filtered
     *
     * @access public
     */
    public function __construct(\Traversable $datasource)
    {
        $this->datasource = $datasource;
    }

    /**
     * Implentation of the Iterator SPL class for Current(), 
     * returns the current element of the data source
     * Returns null if nothing found
     * 
     * @access public
     *
     * @return mixed Current value of the iterator
     */
	public function current()
	{
		return current($this->datasource);
	}

    /**
     * Implentation of the Iterator SPL class for Key(), 
     * returns the current element's identification of the data source
     * Returns null if nothing found
     * 
     * @access public
     *
     * @return mixed Value.
     */
	public function key()
	{
		return key($this->datasource);
	}

    /**
     * Implentation of the Iterator SPL class for Next(), 
     * prepares the next record in line to be read and return by Current() and Key()
     * 
     * @access public
     */
	public function next()
	{
        $valid = false;
        while($valid == false && each($this->datasource) !== false)
        {
            foreach($this->filterCallbacks as $callback)
            {
                if(($valid = $callback(current($this->datasource), key($this->datasource))) == false)
                {
                    break;
                }
            }
        }
	}

    /**
     * Implentation of the Iterator SPL class for Rewind(), 
     * prepares the whole datasource for an entirely new iterator operation
     * 
     * @access public
     */
	public function rewind()
	{
        reset($this->datasource);
	}

    /**
     * Implentation of the Iterator SPL class for Valid(), 
     * returns a boolean stating if the iterator is in a valid state to return data
     * 
     * @access public
     *
     * @return bool Is there any data left to be read
     */
	public function valid()
	{
		return key($this->datasource) != NULL;
	}

    /**
     * Adds a new filter callback to the stack of filters to execute
     * Callback function must accept a $data parameter that will be sent to you and an optional $key parameter
     * 
     * @param \callable Callback function to execute on each iteration
     *
     * @access public
     *
     * @return self To allow method chaining
     */
    public function where(\callable $filterCallback)
    {
        $this->filterCallbacks[] = $filterCallback;
        return $this;
    }

    /**
     * Clears the filter callback stack
     *
     * @access public
     *
     * @return self To allow method chaining
     */
    public function clearFilters()
    {
        $this->filterCallbacks = array();
        return $this;
    }

    /**
     * Returns the filters in this data filter iterator
     *
     * @access public
     *
     * @return array All filters associated with this filter
     */
    public function getFilters()
    {
        return $this->filterCallbacks;
    }

}