<?php

namespace CrazyCodr\Data\Filter;

/**
* The filter class is an iterator iterator that features facilities to easily filter content of an enumerable
* using anonymous functions.
*
* @uses     iterator
*
* @abstract
*
* @category Base class
* @package  CrazyCodr/Data-Filter
* @author   CrazyOne@CrazyCoders
* @license  MIT
* @link     crazycoders.net
*/
class FilterIterator implements \iterator, FilterContainerInterface
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
     * Contains the filter container used to contain the filters for this filter iterator
     *
     * @var FilterContainerInterface
     *
     * @access protected
     */
    protected $container = NULL;

    /**
     * Builds the FilterIterator using a specific datasource
     *
     * @param \Traversable $datasource Contains the datasource that will be iterated and filtered
     * @param FilterContainerInterface Filter container that will be proxied to store first level filters
     *
     * @access public
     */
    public function __construct(\Traversable $datasource = NULL, FilterContainerInterface $filterContainer = NULL)
    {

        //Set the datasource
        $this->setDatasource($datasource);

        //Set the filter container
        $this->setFilterContainer($filterContainer);

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
     * When called with data and some identification key, the function should attempt to resolve
     * some kind of filtering decision operation and return if yes or no the current data should be kept
     * 
     * @param mixed $data Data to be used in the filtering operation
     * @param mixed $key  Identification key to be used in the filtering operation
     * 
     * @return bool Should we keep this data, may return NULL if no filter in the container wants to speak
     */
    function ShouldKeep($data, $key)
    {

        //Proxy the result from ShouldKeep of filterContainer
        $result = $this->getFilterContainer()->ShouldKeep($data, $key);

        //If the result is null, set as true as abstinence at this level means we don't mind keeping it
        if($result === NULL)
        {
            $result = true;
        }

        //Return the result
        return $result;

    }

    /**
     * Used to set the container type of the filter container
     *
     * @return int CONTAINER_TYPE_* of the filter container
     */
    function getContainerType()
    {
        return $this->getFilterContainer()->getContainerType();
    }

    /**
     * Used to set the container type of the filter container
     *
     * @param int $type CONTAINER_TYPE_* of the filter container
     */
    function setContainerType($type)
    {
        $this->getFilterContainer()->setContainerType($type);
    }

    /**
     * Adds a filter with $name to the container
     * If the $name is not set, a new automatic numeric index is used
     *
     * @param FilterInterface $filter Filter to add to the container for later processing
     * @param String $name If null (Default) will simply add the filter with a new key, else tries to add the current filter with the new filter
     *
     * @throws FilterAlreadyExistsException
     *
     * @return string Index/Name of the added filter
     */
    function addFilter(FilterInterface $filter, $name = NULL)
    {
        $this->getFilterContainer()->addFilter($filter, $name);
    }

    /**
     * Replaces a filter with $name
     *
     * @param FilterInterface $filter Filter to add to the container for later processing
     * @param String $name Name of the filter to replace
     *
     * @throws FilterNotFoundException
     *
     * @return string Index/Name of the added/set filter
     */
    function setFilter(FilterInterface $filter, $name)
    {
        $this->getFilterContainer()->setFilter($filter, $name);
    }

    /**
     * Finds if a filter exists in this collection
     *
     * @param String $name Name of the filter you want to find
     *
     * @return bool Does the filter exist in the collection
     */
    function hasFilter($name)
    {
        $this->getFilterContainer()->hasFilter($name);
    }

    /**
     * Removes a filter with $name
     *
     * @param String $name Name of the filter you want to find
     *
     * @throws FitlerNotFoundException
     */
    function removeFilter($name)
    {
        $this->getFilterContainer()->removeFilter($name);
    }

    /**
     * Clears the collection of filters
     */
    function clearFilters()
    {
        $this->getFilterContainer()->clearFilters();
    }

    /**
     * Returns the collection of filters
     *
     * @return Array Collection of all filters in the group
     */
    function getFilters()
    {
        return $this->getFilterContainer()->getFilters();
    }

}