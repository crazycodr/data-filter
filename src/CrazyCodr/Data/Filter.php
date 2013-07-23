<?php

namespace CrazyCodr\Data;

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
     * Defines a filter type that applies AND to all closures of the same group
     */
    const FILTER_TYPE_ALL = 0;

    /**
     * Defines a filter type that applies OR to all closures of the same group
     */
    const FILTER_TYPE_ANY = 1;

    /**
     * Contains the datasource that will be iterated over applying filtering functions to it
     *
     * @var \Traversable
     *
     * @access protected
     */
    protected $datasource = NULL;

    /**
     * Contains the filter 
     *
     * @var int
     *
     * @access protected
     */
    protected $mainFilterType = self::FILTER_TYPE_ALL;

    /**
     * Contains the callbacks to execute when iterating data
     * Every callback must include a $data parameter to receive data and returns a boolean stating if the filter applies
     *
     * @var \Array
     *
     * @access protected
     */
    protected $filterGroups = array();

    /**
     * Contains the types of each filter group in the filter Groups array
     *
     * @var \Array
     *
     * @access protected
     */
    protected $filterGroupTypes = array();

    /**
     * Builds the Filter using a specific datasource
     *
     * @param \Traversable $datasource Contains the datasource that will be iterated and filtered
     *
     * @access public
     */
    public function __construct($datasource = NULL, $mainFilterType = self::FILTER_TYPE_ALL)
    {

        //Set the datasource
        $this->datasource = $datasource;

        //Set the filter type
        $this->setMainFilterType($mainFilterType);

    }

    public function setMainFilterType($type)
    {
        if(!in_array($type, array(self::FILTER_TYPE_ALL, self::FILTER_TYPE_ANY)))
        {
            throw new \InvalidArgumentException('Invalid filter type, use Filter::FILTER_TYPE_ALL or Filter::FILTER_TYPE_ANY');
        }
        $this->mainFilterType = $type;
    }

    public function getMainFilterType()
    {
        return $this->mainFilterType;
    }

    public function getFilterGroupType($name)
    {
        return $this->filterGroupTypes[$name];
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
        do
        {
            next($this->datasource);
        }
        while($this->valid() && $this->shouldKeep() == false);
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
        while($this->valid() && $this->shouldKeep() == false)
        {
            $this->next();
        }
	}

    /**
     * Function used to analyse if the current item should be kept
     * 
     * @access protected
     *
     * @return bool Keep or not the current entry
     */
    protected function shouldKeep()
    {

        //Process each filter groups independantly and then combine the result to a master variable
        $masterResult = NULL;
        foreach($this->filterGroups as $groupName => $callbacks)
        {

            //Process the filter group
            $result = $this->processFilterGroup($callbacks, $groupName);

            //If the filter type is ALL
            if($this->getMainFilterType() == self::FILTER_TYPE_ALL)
            {
                $masterResult = ($masterResult == NULL ? $result : $masterResult && $result);
                if($masterResult == false)
                {
                    //ALL is an AND operator, if masterResult is false, it will never be true, return immediately
                    return false;
                }
            }
            elseif($this->getMainFilterType() == self::FILTER_TYPE_ANY)
            {
                $masterResult = ($masterResult == NULL ? $result : $masterResult || $result);
                if($masterResult == true)
                {
                    //ANY is an OR operator, if masterResult is true, it will never be false, return immediately
                    return true;
                }
            }

        }

        //Return the master result in case all are TRUE in a AND scenario or all FALSE in a OR scenario
        return $masterResult;

    }

    /**
     * Processes a group of filters and return the resulting boolean value of the tests at hand
     * 
     * @access protected
     *
     * @return bool Result of the filter group
     */
    protected function processFilterGroup(array $filters, $name)
    {

        $masterResult = NULL;
        foreach($filters as $filter)
        {

            //Get the results of the filter
            $result = $filter(current($this->datasource), key($this->datasource));

            //If the filter type is ALL
            if($this->getFilterGroupType($name) == self::FILTER_TYPE_ALL)
            {
                $masterResult = ($masterResult == NULL ? $result : $masterResult && $result);
                if($masterResult == false)
                {
                    //ALL is an AND operator, if masterResult is false, it will never be true, return immediately
                    return false;
                }
            }
            elseif($this->getFilterGroupType($name) == self::FILTER_TYPE_ANY)
            {
                $masterResult = ($masterResult == NULL ? $result : $masterResult || $result);
                if($masterResult == true)
                {
                    //ANY is an OR operator, if masterResult is true, it will never be false, return immediately
                    return true;
                }
            }

        }

        //Return the master result in case all are TRUE in a AND scenario or all FALSE in a OR scenario
        return $masterResult;

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
		return key($this->datasource) !== NULL;
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
    public function where(\closure $filterCallback, $name = NULL, $filterGroupType = self::FILTER_TYPE_ALL)
    {
        if($name != NULL)
        {
            $this->filterGroups[$name][] = $filterCallback;
            $this->filterGroupTypes[$name] = $filterGroupType;
        }
        else
        {
            $this->filterGroups[][] = $filterCallback;
        }
        return $this;
    }

    /**
     * Clears the filter callback stack
     *
     * @access public
     *
     * @return self To allow method chaining
     */
    public function clearFilters($name = NULL)
    {
        if($name != NULL)
        {
            unset($this->filterGroups[$name]);
        }
        else
        {
            $this->filterGroups = array();
        }
        return $this;
    }

    /**
     * Returns the filters in this data filter iterator
     *
     * @access public
     *
     * @return array All filters associated with this filter
     */
    public function getFilters($name = NULL)
    {
        if($name != NULL)
        {
            return $this->filterGroups[$name];
        }
        return $this->filterGroups;
    }

}