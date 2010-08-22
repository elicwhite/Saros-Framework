<?php
class Saros_Acl_Adapter_Spot_Entity_Roles extends Spot_Entity_Abstract
{
	// table name
	protected $_datasource = "saros_UserRoles";

	// Field list
	public $userId = array("type" => "int");
	public $roleId = array("type" => "int");
}
?>
