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

//Basic filter setup
$filteredData = new cdf\FilterIterator(new cdf\FilterGroup(), $data);

//Display data
$filteredData->addFilter($oddNumbers);
foreach($filteredData as $data)
{
	echo $data.',';
}
echo '<hr>';