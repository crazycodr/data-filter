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

//Basic filter setup
$filteredData = new cdf\FilterIterator(new cdf\FilterGroup(), $data);

//You can add filters as we loop, filters are executed in the iteration process, not as a preprocessor
//In this example, we'll take only oddNumbers and add the Modulo5 filter when we are pass 5
$filteredData->addFilter($oddNumbers);
foreach($filteredData as $data)
{

	//If we are greater than 5 on this run, forcefully 7 because we are using oddNumbers filter,
	//add the modulo5 filter if it doesn't already exist, this will automatically skip to 15 because 10 isn't odd
	if($data > 5 && $filteredData->hasFilter('modulo5') == false)
	{
		$filteredData->addFilter($modulo5, 'modulo5');
	}
	echo $data.',';

}
echo '<hr>';