<?php
class Application_Mappers_TestMptt extends Spot_Mapper_Tree_Mptt
{
	// table name
	protected $_datasource = "mptt_navigation";
		
	// Field list
	public $name = array("type" => "string");
}