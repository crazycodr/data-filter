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
$filteredData = new cdf\FilterIterator(new cdf\FilterGroup(cdf\FilterGroup::CONTAINER_TYPE_ANY), $data);

//You can add FilterGroups as filters, they will just execute filters in them and return the result
//It's a good practice to either create your groups before, fill them out and then add them or add them with a name
$filteredData->addFilter(new cdf\FilterGroup(), 'oddLessThan5');
$filteredData->addFilter(new cdf\FilterGroup(), 'evenMoreThan15');

//Then, let's add filters on each group
//You could actually add more filter groups, but let's not get crazy in this example
$filteredData->getFilter('oddLessThan5')->addFilter($oddNumbers);
$filteredData->getFilter('oddLessThan5')->addFilter($lessThan5);
$filteredData->getFilter('evenMoreThan15')->addFilter($evenNumbers);
$filteredData->getFilter('evenMoreThan15')->addFilter($moreThan15);

//Running this filter will do a OR on the two groups but each group forces a AND on each filter in each group
foreach($filteredData as $data)
{
	echo $data.'<br>';
}
echo '<hr>';