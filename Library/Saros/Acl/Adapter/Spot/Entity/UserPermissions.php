<?php
class Saros_Acl_Adapter_Spot_Entity_UserPermissions extends Spot_Entity_Abstract
{
	// table name
	protected $_datasource = "saros_UserPermissions";

	// Field list
	public $userId = array("type" => "int");
	public $resource = array("type" => "string");
	public $opValue = array("type" => "text");
}
?>
