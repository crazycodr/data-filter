<?php

class DataTypeFilterTests extends PHPUnit_Framework_TestCase
{

	public function testIterableWithoutData()
	{
		$testData = array();
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter->where(function($a){ return true; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(0, $resultData);
	}

	/**
     * @expectedException PHPUnit_Framework_Error
     */
	public function testNotIterable()
	{
		$testData = 'hello';
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter->where(function($a){ return true; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(0, $resultData);
	}

	public function testWithScalarArray()
	{
		$testData = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter->where(function($a){ return true; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(10, $resultData);
	}

	public function testWithArrayOfArray()
	{
		$testData = array(
			array(1, 'hyundai', 'elantra'),
			array(2, 'honda', 'civic'),
			array(3, 'toyota', 'corolla'),
			array(4, 'ford', 'focus'),
			array(5, 'audi', 'a4'),
			array(6, 'bmw', 'i323'),
		);
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter->where(function($a){ return true; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(6, $resultData);
	}

	public function testWithArrayOfObjects()
	{

		$testData = array(
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
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter->where(function($a){ return true; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(34, $resultData);

	}

}

class FunctionnalFilterTests extends PHPUnit_Framework_TestCase
{

	public function testWithScalarArray()
	{
		$testData = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter->where(function($a){ return ($a % 2) == 0; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(5, $resultData);
	}

	public function testWithArrayOfArray()
	{
		$testData = array(
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
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter->where(function($a){ return $a[1] == 'hyundai'; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(4, $resultData);
	}

	public function testWithArrayOfObjects()
	{

		$testData = array(
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
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter->where(function($a){ return $a->type == 'suv'; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(10, $resultData);

	}

	public function testDefaultFilterType()
	{
		$testData = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$this->assertEquals(\CrazyCodr\Data\Filter::FILTER_TYPE_ALL, $datafilter->getMainFilterType());
	}

	public function testSpecificALLFilterType()
	{
		$testData = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		$datafilter = new \CrazyCodr\Data\Filter($testData, \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$this->assertEquals(\CrazyCodr\Data\Filter::FILTER_TYPE_ALL, $datafilter->getMainFilterType());
	}

	public function testSpecificANYFilterType()
	{
		$testData = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		$datafilter = new \CrazyCodr\Data\Filter($testData, \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
		$this->assertEquals(\CrazyCodr\Data\Filter::FILTER_TYPE_ANY, $datafilter->getMainFilterType());
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidFilterType()
	{
		$testData = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		$datafilter = new \CrazyCodr\Data\Filter($testData, -1);
	}

	public function testALLFiltersOutput()
	{
		$testData = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		$datafilter = new \CrazyCodr\Data\Filter($testData, \CrazyCodr\Data\Filter::FILTER_TYPE_ALL);
		$datafilter->where(function($a){ return ($a % 2) == 0; });
		$datafilter->where(function($a){ return $a > 5; });
		$this->assertEquals(3, count(iterator_to_array($datafilter)));
	}

	public function testANYFiltersOutput()
	{
		$testData = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		$datafilter = new \CrazyCodr\Data\Filter($testData, \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
		$datafilter->where(function($a){ return ($a % 2) == 0; });
		$datafilter->where(function($a){ return $a > 5; });
		$this->assertEquals(7, count(iterator_to_array($datafilter)));
	}

}

class FunctionnalMultipleFilterTests extends PHPUnit_Framework_TestCase
{

	public function testWithScalarArray()
	{
		$testData = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter
			->where(function($a){ return ($a % 2) == 0; })
			->where(function($a){ return $a > 5; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(3, $resultData);
	}

	public function testWithArrayOfArray()
	{
		$testData = array(
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
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter
			->where(function($a){ return $a[1] == 'audi'; })
			->where(function($a){ return $a[3] == 'intermediate'; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(2, $resultData);
	}

	public function testWithArrayOfObjects()
	{

		$testData = array(
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
		$resultData = array();
		$datafilter = new \CrazyCodr\Data\Filter($testData);
		$datafilter
			->where(function($a){ return $a->id > 23; })
			->where(function($a){ return $a->type == 'sport'; });
		foreach($datafilter as $filteredItem)
		{
			$resultData[] = $filteredItem;
		}
		$this->assertCount(2, $resultData);

	}

}

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