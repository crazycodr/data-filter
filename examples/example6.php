<?php
include('../vendor/autoload.php');
use \CrazyCodr\Data\Filter as cdf;

//Setup sample data to work with
$data = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);

//Its a good practice to create your closure filters as concrete classes instead of abstract closure filters
//It makes for more accurate test driven development
class OddNumbersFilter extends cdf\ClosureFilter {
	public function __construct(){ parent::__construct(function($data){ return ($data % 2) == 1; }); }
}
class MoreThan10Filter extends cdf\ClosureFilter {
	public function __construct(){ parent::__construct(function($data){ return $data > 10; }); }
}

//Same thing goes for FilterIterators, you can create concrete versions of them
class ImportantNumbersFilter extends cdf\FilterIterator {
	public function __construct($data){ 
		parent::__construct(new cdf\FilterGroup(), $data); 
		$this->addFilter(new OddNumbersFilter());
		$this->addFilter(new MoreThan10Filter());
	}
}

//Because this is all in one file, it looks ugly, but you can split that in many files just like
//you would do with other concrete classes and the code becomes much easier to read
$filteredData = new ImportantNumbersFilter($data);

//Running this filter will do a OR on the two filters and in this case return everything
foreach($filteredData as $data)
{
	echo $data.'<br>';
}
echo '<hr>';