<?php
// Mock Acl adapter class that contains only permissions directly on the user
// Aka, the user is in no roles, but has one permission directly on them
class Fixture_Acl_Adapter_UserOnly implements Saros_Acl_Adapter_Interface
{
	public function getUserPermissions()
	{
		$result = array();
		$values = array();
		$values["View"] = true;
		$result["Admin"] = $values;

		return $result;
	}
	public function getUserRoles()
	{
		return array();
	}
	public function getHierarchy($roleId)
	{
		return array();
	}
	public function getRolePermissions($roleId)
	{
		return array();
	}
}