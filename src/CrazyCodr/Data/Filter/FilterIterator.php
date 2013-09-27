<?php

namespace CrazyCodr\Data\Filter;

/**
* The filter iterator class is an iterator over an iterator that features 
* facilities to easily filter content of an enumerable using anonymous functions/closures
* or other types of FilterInterfaces.
*
* You can also use many imbricated FilterGroup objects to create trees of conditions
* that must or musn't be satisfied when filtering information.
*
* Important note, the filter iterator filters data from it's datasource in a live fashion
* it doesn't preprocess everthing. Therefore, you can add/remove filters as you read data and
* change the way the filter iterator operates.
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
     * @param FilterContainerInterface Filter container that will be proxied to store first level filters
     * @param \Traversable $datasource Contains the datasource that will be iterated and filtered
     *
     * @throws \InvalidArgumentException Thrown if $datasource is not an array or traversable
     *
     * @access public
     */
    public function __construct(FilterContainerInterface $filterContainer, $datasource = NULL)
    {

        //Set the datasource
        $this->setDatasource($datasource);

        //Set the filter container
        $this->setFilterContainer($filterContainer);

    }

    /**
     * Sets the datasource to be used in the iteration context
     * 
     * @param \Traversable $datasource Datasource to be used in iteration context
     *
     * @throws \InvalidArgumentException Thrown if $datasource is not an array or traversable
     *
     * @access public
     */
    public function setDatasource($datasource = NULL)
    {

        //If there are no datasource, set it to an empty array
        if($datasource === NULL)
        {
            $datasource = array();
        }

        //If datasouce is an array, wrap to array iterator to support iterator interface
        if(is_array($datasource))
        {
            $datasource = new \ArrayIterator($datasource);
        }

        //Validate
        if(!($datasource instanceof \Traversable))
        {
            throw new \InvalidArgumentException('Datasource must be either an array or \\Traversable');
        }

        //Save the datasource
        $this->datasource = $datasource;
        
    }

    /**
     * Returns the current datasource used in the iteration context
     * 
     * @access public
     *
     * @return \Traversable Datasource used in the iteration context
     */
    public function getDatasource()
    {
        return $this->datasource;
    }

    /**
     * Sets the filterContainer to be used in the filter storage context
     * 
     * @param FilterContainerInterface $filterContainer FilterContainer to use in this iterator
     *
     * @access public
     */
    public function setFilterContainer(FilterContainerInterface $filterContainer = NULL)
    {
        $this->filterContainer = $filterContainer;
    }

    /**
     * Returns the current filterContainer used in the filter storage context
     * 
     * @access public
     *
     * @return FilterContainerInterface FilterContainer used in the filter storage context
     */
    public function getFilterContainer()
    {
        return $this->filterContainer;
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
        return $this->datasource->current();
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
        return $this->datasource->key();
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
            $this->datasource->next();
        }
        while($this->valid() && $this->shouldKeep($this->current(), $this->key()) == false);
    }

    /**
     * Implentation of the Iterator SPL class for Rewind(), 
     * prepares the whole datasource for an entirely new iterator operation
     * 
     * @access public
     */
    public function rewind()
    {
        $this->datasource->rewind();
        while($this->valid() && $this->shouldKeep($this->current(), $this->key()) == false)
        {
            $this->next();
        }
    }

    /**
     * Implentation of the Iterator SPL class for Valid(), 
     * Checks if the current item is a valid item for processing
     * NULL keys represent an invalid item
     * 
     * @access public
     */
    public function valid()
    {
        return $this->datasource->valid();
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
    function shouldKeep($data, $key)
    {

        //Proxy the result of shouldKeep to filterContainer
        $result = $this->getFilterContainer()->shouldKeep($data, $key);

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
     * @throws FilterAlreadyExistsException Thrown if the $name already exists
     *
     * @return string Index/Name of the added filter
     */
    function addFilter(FilterInterface $filter, $name = NULL)
    {
        return $this->getFilterContainer()->addFilter($filter, $name);
    }

    /**
     * Replaces a filter with $name
     *
     * @param FilterInterface $filter Filter to add to the container for later processing
     * @param String $name Name of the filter to replace
     *
     * @throws FilterNotFoundException Thrown if the $name cannot be found
     *
     * @return string Index/Name of the added/set filter
     */
    function setFilter(FilterInterface $filter, $name)
    {
        return $this->getFilterContainer()->setFilter($filter, $name);
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
        return $this->getFilterContainer()->hasFilter($name);
    }

    /**
     * Removes a filter with $name
     *
     * @param String $name Name of the filter you want to find
     *
     * @throws FilterNotFoundException Thrown if the $name cannot be found
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
     * Returns a specific filter from the collection
     *
     * @param String $name Name of the filter you want to find
     *
     * @throws FilterNotFoundException Thrown if the $name cannot be found
     *
     * @return FilterInterface Filter requested
     */
    function getFilter($name)
    {
        return $this->getFilterContainer()->getFilter($name);
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

    /**
     * Checks if a filter exists when called via an array access method
     * 
     * @param mixed $key Key to check if valid
     *
     * @access public
     *
     * @return bool Returns if the filter exists
     */
    function offsetExists($key)
    {
        return $this->getFilterContainer()->offsetExists($key);
    }

    /**
     * Returns a filter if it exists
     * 
     * @param mixed $key Key to find and return
     *
     * @access public
     *
     * @throws FilterNotFoundException Thrown if the $name cannot be found
     *
     * @return FilterInterface Requested filter
     */
    function offsetGet($key)
    {
        return $this->getFilterContainer()->offsetGet($key);
    }

    /**
     * Returns a filter if it exists
     * 
     * @param mixed $key Key to find and return
     * @param FilterInterface $value Filter to add to the collection of filters
     *
     * @throws InvalidArgumentException Thrown if the $value is not a FilterInterface
     *
     * @access public
     */
    function offsetSet($key, $value)
    {
        $this->getFilterContainer()->offsetSet($key, $value);
    }

    /**
     * Destroys an existing filter if found
     * 
     * @param mixed $key Key to destroy
     *
     * @access public
     *
     * @throws FilterNotFoundException Thrown if the $name cannot be found
     */
    function offsetUnset($key)
    {
        $this->getFilterContainer()->offsetUnset($key);
    }

}
