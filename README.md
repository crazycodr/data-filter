[![Latest Stable Version](https://poser.pugx.org/crazycodr/data-filter/version.png)](https://packagist.org/packages/crazycodr/data-filter) [![Total Downloads](https://poser.pugx.org/crazycodr/data-filter/downloads.png)](https://packagist.org/packages/crazycodr/data-filter) [![Build Status](https://travis-ci.org/crazycodr/data-filter.png?branch=master)](https://travis-ci.org/crazycodr/data-filter)
CrazyCodr/Data/Filter
======================
This package contains facilities to easily filter live iterated data from any enumerable source.

This class features a filtering iterator accompagnied by different filters/filter groups that you can use to filter incoming data from any iteratable data-source. With this class package, you can create simple or complex groups of filters and filters an even be modified on the fly because it is an iterator over an iterator.

Table of contents
-----------------
1. [Installation](#installation)
2. [Creating a basic filtering iterator](#creating-a-basic-filtering-iterator)
3. [Supporting many filters at once](#supporting-many-filters-at-once)
4. [Building complex filtering groups](#building-complex-filtering-groups)
5. [Using components outside of the iterator context](#using-components-outside-of-the-iterator-context)
6. [Creating your own testable classes](#creating-your-own-testable-classes)

Installation
------------

To install it, just include this requirement into your composer.json

```json
{
    "require": {
        "crazycodr/data-filter": "2.*"
    }
}
``` 

And then run composer install/update as necessary.

Creating a basic filtering iterator
-----------------------------------

Creating a filtering iterator requires at least three items:

1. A FilterGroup used to contain the different filters for your iterator
2. A FilterIterator used to iterate your data and provide filtering features
3. A Filter used to detect if the current data should be kept or discarded from the iteration

(Note: This code assumes that you have an array based datasource with columns: Name, Type, Sex and Age)

```PHP
//Create the male only filter
$maleOnlyFilter = new ClosureFilter(function($a){ return $a['sex'] == 'male'; });
$sexBasedFilter = new FilterIterator(new FilterGroup(), $data);
$sexBasedFilter->addFilter($maleOnlyFilter);

//Iterate our data source and automatically only get males
foreach($sexBasedFilter as $employee)
{
	echo 'Employee: '.$employee['name'].'<br>';
}
```

Supporting many filters at once
-------------------------------

The library supports multiple filters at once and will also respect the short-circuiting pattern. (A condition is only fully evaluated if necessary) 

In this case, we have to switch the FilterGroup to "ANY" mode or else nothing will go through.

```PHP
//Create the male only filter and the "female is called julie"
$maleOnlyFilter = new ClosureFilter(function($a){ return $a['sex'] == 'male'; });
$julieFemalesOnlyFilter = new ClosureFilter(function($a){ return $a['sex'] == 'female' && $a['name'] == 'Julie'; });
$sexBasedFilter = new FilterIterator(new FilterGroup(FilterGroup::CONTAINER_TYPE_ANY), $data);
$sexBasedFilter->addFilter($maleOnlyFilter);
$sexBasedFilter->addFilter($julieFemalesOnlyFilter);

//Iterate our data source and automatically only get males or females called Julie
foreach($sexBasedFilter as $employee)
{
	echo 'Employee: '.$employee['name'].'<br>';
}
```

Building complex filtering groups
---------------------------------

Last example showed us a closure filter that add many conditions. What if you want to explode that or combine many different closure filters in groups and sub groups such as:

* MaleOf30OrLess
  * Male Only
  * 30 or less
* FemaleOf30OrMore
  * Female Only
  * 30 or more

```PHP
//Setup the basic filters
$maleOnlyFilter = new ClosureFilter(function($a){ return $a['sex'] == 'male'; });
$femalesOnlyFilter = new ClosureFilter(function($a){ return $a['sex'] == 'female'; });
$age30OrLess = new ClosureFilter(function($a){ return $a['age'] <= 30; });
$age30OrMore = new ClosureFilter(function($a){ return $a['age'] >= 30; });

//Setup the groups
$fullMaleFilter = new FilterGroup();
$fullFemaleFilter = new FilterGroup();
$fullMaleFilter->addFilter($maleOnlyFilter);
$fullMaleFilter->addFilter($age30OrLess);
$fullFemaleFilter->addFilter($femalesOnlyFilter);
$fullFemaleFilter->addFilter($age30OrMore);

//Create the master filter
$sexBasedFilter = new FilterIterator(new FilterGroup(FilterGroup::CONTAINER_TYPE_ANY), $data);
$sexBasedFilter->addFilter($fullMaleFilter);
$sexBasedFilter->addFilter($fullFemaleFilter);

//Iterate our data source and automatically only get males of 30 or less or females of 30 or more
foreach($sexBasedFilter as $employee)
{
	echo 'Employee: '.$employee['name'].'<br>';
}
```
The important aspect to remember is that, by default, FilterGroups are "ALL" groups and must be changed to "ANY" groups when necessary.

Using components outside of the iterator context
------------------------------------------------

You don't need to use a filtering iterator... The ClosureFilter and FilterGroup can be used outside of a loop. Build conditions normally using concrete/non-concrete classes and call "shouldKeep" with some data.

```PHP
//Create the male only filter and the "female is called julie"
$maleOnlyFilter = new ClosureFilter(function($a){ return $a['sex'] == 'male'; });
$julieFemalesOnlyFilter = new ClosureFilter(function($a){ return $a['sex'] == 'female' && $a['name'] == 'Julie'; });
$filter = new FilterGroup(FilterGroup::CONTAINER_TYPE_ANY);
$filter->addFilter($maleOnlyFilter);
$filter->addFilter($julieFemalesOnlyFilter);

if($filter->shouldKeep($data))
{
	//Do something
}
```

Creating your own testable classes
----------------------------------

The point of this library is not to have to create the iterators and they sub-components each time and be able
to test the lot easily. To this end, simply create concrete extensions of your iterators and sub-components and 
then test them.

```PHP
class MaleOnlyFilter extends ClosureFilter
{
	public function __construct()
	{
		parent::__construct(new ClosureFilter(function($a){ return $a['sex'] == 'male'; }));
	}
}
```

```PHP
class FemaleOnlyFilter extends ClosureFilter
{
	public function __construct()
	{
		parent::__construct(new ClosureFilter(function($a){ return $a['sex'] == 'female'; }));
	}
}
```

```PHP
class SexBasedFilterIterator extends FilterIterator
{
	public function __construct($data)
	{
		parent::__construct(new FilterGroup(), $data);
		$this->addFilter(new MaleOnlyFilter());
		$this->addFilter(new FemaleOnlyFilter());
	}
}
```

It might look extreme but this way you are creating a concrete functional class that can be reused and tested.
Note that DataProviders are a great way to test your components but it will look strange to use a 
DataProvider when testing the iterators.

```PHP
class MaleOnlyFilterTest extends PHPUnit_Framework_TestCase
{

	/**
	* @dataProvider maleOnlyFilterDataProvider
	*/
	public function testShouldKeep($data)
	{
		$filter = new MaleOnlyFilter();
		$this->assertEquals($data['expected'], $filter->shouldKeep($data['testdata']));
	}
	
	public function maleOnlyFilterDataProvider()
	{
		return array(
			array(
				'expected' => true,
				'testdata' => array('name' => 'John doe', 'age' => 35, 'sex' => 'male'),
			),
			array(
				'expected' => false,
				'testdata' => array('name' => 'Jone doe', 'age' => 30, 'sex' => 'female'),
			),
		);
	}
	
}
```
