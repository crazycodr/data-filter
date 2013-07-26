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
interface FilterInterface
{

    /**
     * When called with data and some identification key, the function should attempt to resolve
     * some kind of filtering decision operation and return if yes or no the current data should be kept
     * 
     * @param mixed $data Data to be used in the filtering operation
     * @param mixed $key  Identification key to be used in the filtering operation
     * 
     * @return bool Should we keep this data
     */
	function shouldKeep($data, $key);

}