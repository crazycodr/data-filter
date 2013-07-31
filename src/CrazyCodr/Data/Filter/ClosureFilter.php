<?php

namespace CrazyCodr\Data\Filter;

/**
* This class represents a filter based on a closure.
*
* The closure should accept two parameters: $data and $key, both not typed.
*
* The $data parameter is usually some kind of object or array of data while
* the $key is most oftenly a scalar string value representing the id of the item.
*
* @category Filter organisation
* @package  CrazyCodr/Data-Filter
* @author   CrazyOne@CrazyCoders
* @license  MIT
* @link     crazycoders.net
*/
class ClosureFilter implements FilterInterface
{

    /**
     * Contains the closure represented by this filtering closure
     *
     * @var closure
     *
     * @access protected
     */
    protected $closure = NULL;

     /**
      * Builds a new ClosureFilter by specifying the closure and options
      * 
      * @param \Closure $closure Closure to use while filtering data, must accept two parameters with no type hint, parameter1 $data, parameter2 $key
      */
    public function __construct(\Closure $closure)
    {
        $this->setClosure($closure);
    }

    /**
     * Sets the closure used by this closure filter when filtering data
     * Closure must accept two parameters with no type hint, parameter1 $data, parameter2 $key
     * 
     * @param mixed \Closure Closure must accept two parameters with no type hint, parameter1 $data, parameter2 $key
     *
     * @access public
     */
    public function setClosure(\Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * Returns the current closure used to filter data
     *
     * @access public
     *
     * @return \Closure Closure used to filter data
     */
    public function getClosure()
    {
        return $this->closure;
    }

    /**
     * When called with data and some identification key, the function should attempt to resolve
     * some kind of filtering decision operation and return if yes or no the current data should be kept
     * 
     * @param mixed $data Data to be used in the filtering operation
     * @param mixed $key  Identification key to be used in the filtering operation
     *
     * @access public
     *
     * @return bool Should we keep this data
     */
    public function shouldKeep($data, $key)
    {
        $closure = $this->getClosure();
        return $closure($data, $key);
    }

}