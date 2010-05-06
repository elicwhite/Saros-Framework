<?php
class Application_Mappers_TestMptt extends Library_Database_Mapper_Tree_Mptt
{
	// table name
	protected $_datasource = "mptt_navigation";
		
	// Field list
	public $name = array("type" => "string");
}