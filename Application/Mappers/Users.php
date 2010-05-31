<?php
class Application_Mappers_Users extends Spot_Mapper_Abstract
{
	// table name
	protected $table = "board_users";

	// Keep our primary key seperate for speed
	protected $primary = "id";

	// Field list
	protected $fields = array(
		"id" => array("type" => "int"),
		"username" => array("type" => "varchar"),
		"password" => array("type" => "varchar"),
		"email" => array("type" => "varchar"),
		"active" => array("type" => "int"),
	);
}