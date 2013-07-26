<?php
include('../vendor/autoload.php');

//Set the time limit
set_time_limit(5);

//Setup sample data to work with
$data = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);

//Basic filter usage
$filteredData = new \CrazyCodr\Data\Filter\FilterIterator(new \CrazyCodr\Data\Filter\FilterGroup(), $data);

//Setup basic filters
$filteredData->addFilter(new \CrazyCodr\Data\Filter\ClosureFilter(function($data, $key){
	return ($data % 3) == 0;
}));

foreach($filteredData as $data)
{
	echo $data.'<br>';
}