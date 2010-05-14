<?php
class Application_Mappers_Downloads extends Spot_Mapper_Abstract
{
	// table name
	protected $_datasource = "file_downloads";
		
	// Field list
	public $id = array("type" => "int", "primary" => true);
	public $product = array("type" => "string");
	public $timestamp = array("type" => "int");
	public $ip = array("type" => "string");
	public $referer = array("type" => "string");
}