CrazyCodr/Data/Filter
=====================

This package contains facilities to easily filter data from any enumerable source.

This class features a single filter iterator accompagnied by filter group and a closure filter adapter that you can use to filter out data as you iterate it. It offers slightly more complex features that the ones of a SPL FilterIterator in a sense that you can manage multiple filters at once, clear the lot, dynamically add new conditions to it as you go, etc.

Why should i use it over SPL FilterIterator
-------------------------------------------

1. Every class is designed to be extended to create concrete filtering classes which makes for better TDD
2. The iterator can be changed live (add/remove conditions/groups) to change the behavior of the iterator
3. You can use your filters outside the scope of an iteration using $filter->shouldKeep();

How to use
----------

1. Create a datasource that can be iterated
2. Create ClosureFilter objects that will execute what you want to filter out
3. Create a FilterGroup and add all filters to it
4. Create a FilterIterator and add the datasource and filtercontainer to it
5. Iterate, rinse, repeat...

Whats next for you?
-------------------

1. Download the package through composer "crazycodr/data-filter" and then look in the documentation directory of the package to know more about it, it's actually quite simple but so powerful
2. Look at the example
3. Try and build some tests using real life data such as CSV files
4. Use in production

A few quick examples
--------------------

**Basic setup for all examples below**

This code here will be used in all examples, paste it in front of each example, it will save use some display space.

```PHP
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
```

**Basic usage**

The fun aspect of this class is that you can prepare filtering closures in advance, they could be simple closures in another file that you test using unit tests. In this case, we prepare those closures in advance and add the right closures to the filtering process.

```PHP
//Basic filter setup
$filteredData = new cdf\FilterIterator(new cdf\FilterGroup(), $data);

//Display data
$filteredData->addFilter($oddNumbers);
foreach($filteredData as $data)
{
	echo $data.',';
}
```
Results in
```
1,3,5,7,9,11,13,15,17,19,
```

**Support for grouped constraints**

By default, the FilterIterator uses a simple FilterGroup for better extension. The FilterGroup can be set to ANY mode instead of AND mode (default) and then the conditions complement each other.

```PHP
//You can set the filter group to use a ANY condition, by default, it uses a ALL condition
$filteredData = new cdf\FilterIterator(new cdf\FilterGroup(cdf\FilterGroup::CONTAINER_TYPE_ANY), $data);

//Display data
$filteredData->addFilter($oddNumbers);
$filteredData->addFilter($moreThan15);
foreach($filteredData as $data)
{
	echo $data.',';
}
```
Results in
```
1,3,5,7,9,11,13,15,16,17,18,19,20,
```