<?php
class Application_Mappers_TestMptt extends Library_Database_Mapper_Tree_Mptt
{
	// table name
	protected $_datasource = "mptt_navigation";
		
	// Field list
	public $id = array("type" => "int", "primary" => true);
	public $name = array("type" => "string");
	public $timeadded = array("type" => "int");
}