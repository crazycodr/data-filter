<?php
include('../vendor/autoload.php');
use \CrazyCodr\Data\Filter as cdf;

//Setup sample data to work with
$data = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);

//Create your filters, alternatively, it is better to create concrete classes, it becomes much more testable
$oddNumbers = new cdf\ClosureFilter(function($data){ return ($data % 2) == 1; });
$evenNumbers = new cdf\ClosureFilter(function($data){ return ($data % 2) == 0; });
$moreThan10 = new cdf\ClosureFilter(function($data){ return $data > 10; });
$moreThan15 = new cdf\ClosureFilter(function($data){ return $data > 15; });
$lessThan10 = new cdf\ClosureFilter(function($data){ return $data < 10; });
$lessThan5 = new cdf\ClosureFilter(function($data){ return $data < 5; });
$modulo5 = new cdf\ClosureFilter(function($data){ return ($data % 5) == 0; });

//Basic filter setup using ANY, then we add two groups in the main filter group
$filteredData = new cdf\FilterIterator(new cdf\FilterGroup(cdf\FilterContainerInterface::CONTAINER_TYPE_ANY), $data);

//You can access the filter group using ArrayAccess methods, just like you were accessing an array
$filteredData['oddNumbers'] = $oddNumbers;
$filteredData['evenNumbers'] = $evenNumbers;

//Running this filter will do a OR on the two filters and in this case return everything
foreach($filteredData as $data)
{
	echo $data.'<br>';
}
echo '<hr>';