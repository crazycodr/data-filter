<?php

namespace CrazyCodr\Data\Filter;

/**
* This class represents a group of filters
*
* @category Filter organisation
* @package  CrazyCodr/Data-Filter
* @author   CrazyOne@CrazyCoders
* @license  MIT
* @link     crazycoders.net
*/
class FilterGroup implements FilterInterface, FilterContainer
{

    /**
     * Contains the filters of the group
     *
     * @var array
     *
     * @access protected
     */
    protected $filters = array();

    /**
     * Contains the filter type of the group
     *
     * @var int
     *
     * @access protected
     */
    protected $filterType = self::CONTAINER_TYPE_ALL;

    /**
     * Builds a new filter group with a default filtering method of ALL
     * 
     * @param int $filterType Type of filtering to use on the container
     *
     * @access public
     */
    public function __construct($filterType = self::CONTAINER_TYPE_ALL)
    {
        $this->setContainerType($filterType);
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

        //Initialize the container of results
        $results = NULL;
        $containerType = $this->getContainerType();

        //Foreach filter, call the ShouldKeep and aggregate the result into $results
        foreach($this->filters as $filter)
        {

            //Get the result of the filter
            $result = $filter->ShouldKeep($data, $key);

            //Aggregate
            if($containerType == self::CONTAINER_TYPE_ALL && ($result === true || $result === false))
            {
                //Aggregate this result as a AND
                $results = ($results == NULL ? $result : $results && $result);
            }
            elsef($containerType == self::CONTAINER_TYPE_ANY && ($result === true || $result === false))
            {
                //Aggregate this result as a OR
                $results = ($results == NULL ? $result : $results || $result);
            }

            //If the results are set to a finite boolean value based on the operator, just return
            if($containerType == self::CONTAINER_TYPE_ALL && $results === false)
            {
                //A false result renders all other filters false on ALL, return false immediately
                return $results;
            }
            elseif($containerType == self::CONTAINER_TYPE_ANY && $result === true)
            {
                //A true result renders all other filters true on ANY, return true immediately
                return $results;
            }

        }

        //This case occurs when all filters either returned NULL values (abstinence) or all values returned matched potential success or failure as a group
        return $results;

    }

    /**
     * Used to set the container type of the filter container
     *
     * @return int CONTAINER_TYPE_* of the filter container
     */
    function getContainerType()
    {
        return $this->filterType;
    }

    /**
     * Used to set the container type of the filter container
     *
     * @param int $type CONTAINER_TYPE_* of the filter container
     */
    function setContainerType($type)
    {
        if($type != self::CONTAINER_TYPE_ALL && $type != self::CONTAINER_TYPE_ANY)
        {
            throw new \InvalidArgumentException('Invalid CONTAINER_TYPE_ value for $type in '.__CLASS__.'::setContainerType($filter)');
        }
        $this->filterType = $type;
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

        //Generate an appropriate name if none
        while($name == NULL)
        {
            $name = 'autofilter_'.rand(1111, 9999);
            if($this->hasFilter($name))
            {
                $name = NULL;
            }
        }

        //Check if the name exists
        if($this->hasFilter($name))
        {
            throw new FilterAlreadyExistsException($name);
        }

        //Add the filter to the container
        $this->filters[$name] = $filter;

        //Return the name/new name
        return $name;

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

        //Check if the name exists
        if($this->hasFilter($name) == false)
        {
            throw new FilterNotFoundException($name);
        }

        //Add the filter to the container
        $this->filters[$name] = $filter;

        //Return the name/new name
        return $name;

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
        return array_key_exists($name, $this->filters);
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

        //Check if the name exists
        if($this->hasFilter($name) == false)
        {
            throw new FilterNotFoundException($name);
        }

        //Add the filter to the container
        unset($this->filters[$name]);

    }

    /**
     * Clears the collection of filters
     */
    function clearFilters()
    {
        $this->filters = array();
    }

    /**
     * Returns the collection of filters
     *
     * @return Array Collection of all filters in the group
     */
    function getFilters()
    {
        return $this->filters;
    }

}