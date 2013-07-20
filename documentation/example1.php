<?php
include('../vendor/autoload.php');

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