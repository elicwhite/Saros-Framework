<?php
class Saros_Acl_Adapter_Spot_Entity_Roles extends Spot_Entity_Tree_Mptt
{
		// table name
	protected $_datasource = "saros_Roles";

	// Field list
	public $rolename = array("type" => "string");
}
?>
