<?php
class Fixture_Acl_Adapter_SingleRole implements Saros_Acl_Adapter_Interface
{
	public function getUserPermissions()
	{
		return array();
	}
	public function getUserRoles()
	{
		return array(1);
	}
	public function getHierarchy($roleId)
	{
		return array(1);
	}
	public function getRolePermissions($roleId)
	{
		if ($roleId == 1)
		{
			$result = array();
				$values = array();
				$values["View"] = true;
			$result["Article1"] = $values;

			return $result;
		}

		return array();
	}
}