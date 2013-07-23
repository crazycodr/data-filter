<?php
include('../vendor/autoload.php');

class CrazyCodr_Data_Filter_Example1_Mock {
	public $year;
	public $make;
	public $model;
	public $type;
	public function __construct($year, $make, $model, $type){
		$this->year = $year;
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
$filteredData->where(function($a){ return $a->year == 2012; });
$filteredData->where(function($a){ return $a->type == 'SUV'; }, 'typeGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
$filteredData->where(function($a){ return $a->type == 'Compact'; }, 'typeGroup', \CrazyCodr\Data\Filter::FILTER_TYPE_ANY);
foreach($filteredData as $data)
{
	var_dump($data);
	echo '<br>';
}