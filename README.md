CrazyCodr/Data/Filter
=====================

This package contains  facilities to easily filter data from any enumerable source.

This class features, for now, a single iterator that you can use to filter out data as you iterate it. It offers slightly more complex features that the ones of a SPL FilterIterator in a sense that you can manage multiple filters at once, clear the lot, dynamically add new conditions to it as you go, etc.

Quick documentation
-------------------

1. The filter class is an iterator and filters out data live as you iterate.
2. You can change the filter conditions live since it doesn't pre-process the inner iterator
3. Calling `where()` allows you to add conditions to the filter class, you can chain `where()` as long as you want
4. You can clear all filters by calling `clearFilters()` whenever you want

Whats next
----------

1. Create "any()" and "all()" functions that accept groups of closures

Examples
--------

**Using prepared conditions just in time**

The fun aspect of this class is that you can prepare filtering closures in advance, they could be
simple closures in another file that you test using unit tests. In this case, we prepare those closures
in advance and add the right closures to the filtering process.

```PHP

    //Setup the filters
    $filterOutToyota = function($data, $key){ return $data->make != 'Toyota'; }
    $filterOutFord = function($data, $key){ return $data->make != 'Ford'; }
    $filterOutSUV = function($data, $key){ return $data->make != 'suv'; }
    $filterOutSubCompacts = function($data, $key){ return $data->type != 'subcompact'; }
    
    //Setup the data
    $data = <...>
    
    //Setup the filtering
    $filteredData = new \CrazyCodr\Data\Filter($data);
    if($_GET['filters']['make']['toyota'] == 1){ $filteredData->where($filterOutToyota); }
    if($_GET['filters']['make']['ford'] == 1){ $filteredData->where($filterOutToyota); }
    
    //Loop
    foreach($filteredData as $make)
    {
      <...>
    }
    
```

**Chaining support**

CrazyCodr Data Filter supports chaining of filter functions so you can skip repeating over and over 
again the original object that you called when creating a filter.

```PHP
//You can chain the data filtering to create many conditions
$data = <...>;
$filteredData = new \CrazyCodr\Data\Filter($data);
$filteredData
  ->where(function($data, $key){ return $key != 'world'; })
  ->where(function($data, $key){ return $key != 'canada'; })
  ->where(function($data, $key){ return $data->user != 'crazycone'; });
```

**Dynamically adding constraints**

You can add constraint as you loop. The CrazyCodr Data Filter is not a preprocessor filter, 
it filters as you iterate. Thus, you can add filters to it as we go. Although not the best method
this code below allows you to create a dynamic distinct filter base on the model of the vehicule.

```PHP
class CrazyCodr_Data_Filter_Example1_Mock {
  public $id;
	public $make;
	public $model;
	public $type;
	public function __construct($id, $make, $model, $type){
		$this->id = $id;
		$this->make = $make;
		$this->model = $model;
		$this->type = $type;
	}
}

$data = array(
	new CrazyCodr_Data_Filter_Example1_Mock(2010, 'Hyundai', 'Tucson', 'SUV'),
	new CrazyCodr_Data_Filter_Example1_Mock(2011, 'Hyundai', 'Tucson', 'SUV'),
	new CrazyCodr_Data_Filter_Example1_Mock(2012, 'Hyundai', 'Tucson', 'SUV'),
	new CrazyCodr_Data_Filter_Example1_Mock(2012, 'Hyundai', 'Elantra', 'Compact'),
	new CrazyCodr_Data_Filter_Example1_Mock(2013, 'Hyundai', 'Accent', 'SubCompact'),
	new CrazyCodr_Data_Filter_Example1_Mock(2009, 'Hyundai', 'SantaFee', 'SUV'),
	new CrazyCodr_Data_Filter_Example1_Mock(2011, 'Hyundai', 'Genesis', 'Intermediate'),
);
$filteredData = new \CrazyCodr\Data\Filter($data);
foreach($filteredData as $data)
{
	$filterOutThisName = $data->model;
	$filteredData->where(
		function($data)use($filterOutThisName){
			echo 'Filtering on '.$filterOutThisName.'<br>';
			return $data->model != $filterOutThisName; 
		}
	);
	var_dump($data);
	echo '<br>';
}
```