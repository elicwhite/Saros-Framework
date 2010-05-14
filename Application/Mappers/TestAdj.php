<?php
class Application_Mappers_TestAdj extends Spot_Mapper_Tree_Adjacent
{
	// table name
	protected $_datasource = "adj_navigation";
		
	// Field list
	public $name = array("type" => "string");
}