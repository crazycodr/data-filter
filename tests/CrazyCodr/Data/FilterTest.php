<?php

class CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock {
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

class DataTypeFilterTests extends PHPUnit_Framework_TestCase
{

	public $ArrayOfNumbersTestData = NULL;
	public $ArrayOfArrayTestData = NULL;
	public $ArrayOfObjectsTestData = NULL;

	public function setUp()
	{

		//Setup the common array of 10 numbers used in many tests
		$this->ArrayOfNumbersTestData = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

		//Setup the common array of array test data used in many tests
		$this->ArrayOfArrayTestData = array(
			array(1, 'hyundai', 'accent', 'subcompact'),
			array(2, 'hyundai', 'elantra', 'compact'),
			array(3, 'hyundai', 'tucson', 'suv'),
			array(4, 'hyundai', 'santafee', 'suv'),
			array(5, 'honda', 'fit', 'subcompact'),
			array(6, 'honda', 'civic', 'compact'),
			array(7, 'honda', 'accord', 'intermediate'),
			array(8, 'honda', 'cr-v', 'suv'),
			array(9, 'honda', 'pilot', 'suv'),
			array(10, 'toyota', 'yaris', 'subcompact'),
			array(11, 'toyota', 'corolla', 'compact'),
			array(12, 'toyota', 'camry', 'intermediate'),
			array(13, 'toyota', 'prius', 'intermediate'),
			array(14, 'toyota', 'sienna', 'minivan'),
			array(15, 'toyota', 'rav4', 'suv'),
			array(16, 'ford', 'fiesta', 'subcompact'),
			array(17, 'ford', 'focus', 'compact'),
			array(18, 'ford', 'fusion', 'intermediate'),
			array(19, 'ford', 'mustang', 'intermediate'),
			array(20, 'ford', 'explorer', 'suv'),
			array(21, 'ford', 'escape', 'suv'),
			array(22, 'ford', 'edge', 'suv'),
			array(23, 'audi', 'a3', 'subcompact'),
			array(24, 'audi', 'a4', 'compact'),
			array(25, 'audi', 'a5', 'intermediate'),
			array(26, 'audi', 'a6', 'intermediate'),
			array(27, 'audi', 'q5', 'suv'),
			array(28, 'audi', 'tt', 'sport'),
			array(29, 'audi', 'r8', 'super'),
			array(30, 'bmw', 'serie1', 'compact'),
			array(31, 'bmw', 'serie3', 'compact'),
			array(32, 'bmw', 'serie5', 'intermediate'),
			array(33, 'bmw', 'seriex', 'suv'),
			array(34, 'bmw', 'z4', 'sport'),
		);

		//Setup the array of objects test data
		$this->ArrayOfObjectsTestData = array(
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(1, 'hyundai', 'accent', 'subcompact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(2, 'hyundai', 'elantra', 'compact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(3, 'hyundai', 'tucson', 'suv'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(4, 'hyundai', 'santafee', 'suv'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(5, 'honda', 'fit', 'subcompact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(6, 'honda', 'civic', 'compact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(7, 'honda', 'accord', 'intermediate'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(8, 'honda', 'cr-v', 'suv'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(9, 'honda', 'pilot', 'suv'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(10, 'toyota', 'yaris', 'subcompact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(11, 'toyota', 'corolla', 'compact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(12, 'toyota', 'camry', 'intermediate'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(13, 'toyota', 'prius', 'intermediate'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(14, 'toyota', 'sienna', 'minivan'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(15, 'toyota', 'rav4', 'suv'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(16, 'ford', 'fiesta', 'subcompact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(17, 'ford', 'focus', 'compact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(18, 'ford', 'fusion', 'intermediate'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(19, 'ford', 'mustang', 'intermediate'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(20, 'ford', 'explorer', 'suv'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(21, 'ford', 'escape', 'suv'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(22, 'ford', 'edge', 'suv'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(23, 'audi', 'a3', 'subcompact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(24, 'audi', 'a4', 'compact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(25, 'audi', 'a5', 'intermediate'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(26, 'audi', 'a6', 'intermediate'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(27, 'audi', 'q5', 'suv'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(28, 'audi', 'tt', 'sport'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(29, 'audi', 'r8', 'super'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(30, 'bmw', 'serie1', 'compact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(31, 'bmw', 'serie3', 'compact'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(32, 'bmw', 'serie5', 'intermediate'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(33, 'bmw', 'seriex', 'suv'),
			new CrazyCodr_Data_Filter_testWithArrayOfObjects_Mock(34, 'bmw', 'z4', 'sport'),
		);

	}

	public function testIterableWithoutData()
	{
		$datafilter = new \CrazyCodr\Data\Filter(array());
		$datafilter->where(function($a){ return true; });
		$this->assertCount(0, iterator_to_array($datafilter));
	}

	/**
     * @expectedException PHPUnit_Framework_Error
     */
	public function testNotIterable()
	{
		$datafilter = new \CrazyCodr\Data\Filter('hello');
		$datafilter->where(function($a){ return true; });
		$this->assertCount(0, iterator_to_array($datafilter));
	}

	public function testNoConditionsWithScalarArray()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData);
		$datafilter->where(function($a){ return true; });
		$this->assertCount(10, iterator_to_array($datafilter));
	}

	public function testNoConditionsWithArrayOfArray()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfArrayTestData);
		$datafilter->where(function($a){ return true; });
		$this->assertCount(34, iterator_to_array($datafilter));
	}

	public function testNoConditionsWithArrayOfObjects()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfObjectsTestData);
		$datafilter->where(function($a){ return true; });
		$this->assertCount(34, iterator_to_array($datafilter));
	}

	public function testSingleConditionsWithScalarArray()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData);
		$datafilter->where(function($a){ return ($a % 2) == 0; });
		$this->assertCount(5, iterator_to_array($datafilter));
	}

	public function testSingleConditionsWithArrayOfArray()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfArrayTestData);
		$datafilter->where(function($a){ return $a[1] == 'hyundai'; });
		$this->assertCount(4, iterator_to_array($datafilter));
	}

	public function testSingleConditionsWithArrayOfObjects()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfObjectsTestData);
		$datafilter->where(function($a){ return $a->type == 'suv'; });
		$this->assertCount(10, iterator_to_array($datafilter));
	}

	public function testMultipleConditionsWithScalarArray()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData);
		$datafilter
			->where(function($a){ return ($a % 2) == 0; })
			->where(function($a){ return $a > 5; });
		$this->assertCount(3, iterator_to_array($datafilter));
	}

	public function testMultipleConditionsWithArrayOfArray()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfArrayTestData);
		$datafilter
			->where(function($a){ return $a[1] == 'audi'; })
			->where(function($a){ return $a[3] == 'intermediate'; });
		$this->assertCount(2, iterator_to_array($datafilter));
	}

	public function testMultipleConditionsWithArrayOfObjects()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfObjectsTestData);
		$datafilter
			->where(function($a){ return $a->id > 23; })
			->where(function($a){ return $a->type == 'sport'; });
		$this->assertCount(2, iterator_to_array($datafilter));
	}

	public function testDefaultFilterType()
	{
		$datafilter = new \CrazyCodr\Data\Filter(array());
		$this->assertEquals(\CrazyCodr\Data\Filter::FILTER_TYPE_ALL, $datafilter->getMainFilterType());
	}

	public function testSpecificALLFilterType()
	{
		$datafilter = new \CrazyCodr\Data\Filter(array(), \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$this->assertEquals(\CrazyCodr\Data\Filter::FILTER_TYPE_ALL, $datafilter->getMainFilterType());
	}

	public function testSpecificANYFilterType()
	{
		$datafilter = new \CrazyCodr\Data\Filter(array(), \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
		$this->assertEquals(\CrazyCodr\Data\Filter::FILTER_TYPE_ANY, $datafilter->getMainFilterType());
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidFilterType()
	{
		$datafilter = new \CrazyCodr\Data\Filter(array(), -1);
	}

	public function testALLFiltersOutput()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData, \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return ($a % 2) == 0; });
		$datafilter->where(function($a){ return $a > 5; });
		$this->assertCount(3, iterator_to_array($datafilter));
	}

	public function testANYFiltersOutput()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData, \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
		$datafilter->where(function($a){ return ($a % 2) == 0; });
		$datafilter->where(function($a){ return $a > 5; });
		$this->assertCount(7, iterator_to_array($datafilter));
	}

	public function testFilterGroupOutput1()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData, \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
		$datafilter->where(function($a){ return ($a % 2) == 0; });
		$datafilter->where(function($a){ return $a > 5; }, 'rangeGroup');
		$datafilter->where(function($a){ return $a < 10; }, 'rangeGroup');
		$this->assertCount(7, iterator_to_array($datafilter));
	}

	public function testFilterGroupOutput2()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData, \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return ($a % 2) == 0; });
		$datafilter->where(function($a){ return $a > 5; }, 'rangeGroup');
		$datafilter->where(function($a){ return $a < 10; }, 'rangeGroup');
		$this->assertCount(2, iterator_to_array($datafilter));
	}

	public function testFilterGroupOutput3()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData, \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return ($a % 4) == 0; }, 'moduloGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
		$datafilter->where(function($a){ return ($a % 3) == 0; }, 'moduloGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
		$this->assertCount(5, iterator_to_array($datafilter));
	}

	public function testFilterGroupOutput4()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData, \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return ($a % 4) == 0; }, 'moduloGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
		$datafilter->where(function($a){ return ($a % 3) == 0; }, 'moduloGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
		$datafilter->where(function($a){ return $a > 5; }, 'rangeGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return $a < 9; }, 'rangeGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$this->assertCount(2, iterator_to_array($datafilter));
	}

	public function testFilterGroupOutput5()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData, \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return ($a % 2) == 0; }, 'moduloGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return ($a % 3) == 0; }, 'moduloGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return $a > 5; }, 'rangeGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return $a < 9; }, 'rangeGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$this->assertCount(1, iterator_to_array($datafilter));
	}

	public function testFilterGroupOutput6()
	{
		$datafilter = new \CrazyCodr\Data\Filter($this->ArrayOfNumbersTestData, \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
		$datafilter->where(function($a){ return ($a % 2) == 0; }, 'moduloGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return ($a % 3) == 0; }, 'moduloGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return $a > 1; }, 'rangeGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return $a < 3; }, 'rangeGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$this->assertCount(2, iterator_to_array($datafilter));
	}

}