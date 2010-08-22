<?php
class Saros_Acl_Adapter_Spot_Entity_RolePermissions extends Spot_Entity_Abstract
{
	// table name
	protected $_datasource = "saros_RolePermissions";

	// Field list
	public $roleId = array("type" => "int");
	public $resource = array("type" => "string");
	public $opValue = array("type" => "text");
}
?>
