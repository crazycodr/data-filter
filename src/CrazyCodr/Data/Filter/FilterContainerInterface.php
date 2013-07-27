<?php

namespace CrazyCodr\Data\Filter;

/**
* This interface dictates what a filter should be able to do naturaly
*
* @category Interfaces
* @package  CrazyCodr/Data-Filter
* @author   CrazyOne@CrazyCoders
* @license  MIT
* @link     crazycoders.net
*/
interface FilterContainerInterface extends \ArrayAccess
{

    /**
     * Defines the ALL filter type for filtering operations
     */
    const CONTAINER_TYPE_ALL = 0;

    /**
     * Defines the ANY filter type for filtering operation
     */
    const CONTAINER_TYPE_ANY = 1;

    /**
     * Used to set the container type of the filter container
     *
     * @return int CONTAINER_TYPE_* of the filter container
     */
    function getContainerType();

    /**
     * Used to set the container type of the filter container
     *
     * @param int $type CONTAINER_TYPE_* of the filter container
     */
    function setContainerType($type);

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
    function addFilter(FilterInterface $filter, $name = NULL);

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
    function setFilter(FilterInterface $filter, $name);

    /**
     * Finds if a filter exists in this collection
     *
     * @param String $name Name of the filter you want to find
     *
     * @return bool Does the filter exist in the collection
     */
    function hasFilter($name);

    /**
     * Removes a filter with $name
     *
     * @param String $name Name of the filter you want to find
     *
     * @throws FitlerNotFoundException
     */
    function removeFilter($name);

    /**
     * Clears the collection of filters
     */
    function clearFilters();

    /**
     * Returns a specific filter from the collection
     *
     * @param String $name Name of the filter you want to find
     *
     * @throws FitlerNotFoundException
     *
     * @return FilterInterface Filter requested
     */
    function getFilter($name);

    /**
     * Returns the collection of filters
     *
     * @return Array Collection of all filters in the group
     */
    function getFilters();

}