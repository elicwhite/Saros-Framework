<?php
class Application_Mappers_Users extends Library_Database_Table 
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
	
	// relationships
	protected $relations = array(
		// Contacts
		"contacts" => array(
			"id" => "user_id",
		)
	);
}