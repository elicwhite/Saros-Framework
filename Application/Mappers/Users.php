<?php
class Application_Mappers_Users extends Spot_Mapper_Abstract
{
	// table name
	protected $_datasource = "board_users";

	// Field list
	public $id = array("type" => "int", "primary" => true, "serial" => true);
	public $username = array("type" => "string");
	public $password = array("type" => "string");
	public $email = array("type" => "string");
	public $active = array("type" => "int");
}