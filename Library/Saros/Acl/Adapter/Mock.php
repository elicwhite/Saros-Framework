<?php
class Saros_Acl_Adapter_Mock implements Saros_Acl_Adapter_Interface
{
	public function getUserPermissions()
	{
		$result = array();

		$values = array();
		$values["View"] = true;
		$values["Share"] = false;
		$result["Admin"] = $values;

		return $result;
	}

	// SELECT * FROM UsersRoles WHERE UserId = @0
	public function getUserRoles()
	{
		$result = array(5,6);
		return $result;
	}

	// $role = SELECT * FROM Roles WHERE Id = @0
	// SELECT Id FROM Roles WHERE lid <= @0 AND rid >= @1 ORDER BY lid ASC, $role->lid, $role->rid
	public function getHierarchy($roleId)
	{
		if($roleId == 5)
		{
			return array(1,3,5);
		}
		elseif($roleId == 6)
		{
			return array(1,2,6);
		}
	}

	// SELECT * FROM RolesPermissions WHERE RoleId
	public function getRolePermissions($roleId)
	{
		if($roleId == 1)
		{
			return array();
		}
		elseif($roleId == 2)
		{
			$result = array();

			$values = array();
			$values["Share"] = true;
			$result["Admin"] = $values;
			return $result;
		}
		elseif($roleId == 3)
		{
			$result = array();
			$values = array();
			$values["Edit"] = true;
			$values["Delete"] = false;
			$result["Article1"] = $values;

			$values = array();
			$values["Edit"] = false;
			$values["Delete"] = true;
			$result["Article2"] = $values;
			return $result;
		}
		elseif($roleId == 5)
		{
			$result = array();
			$values = array();
			//$values["Edit"] = false;
			$result["Article1"] = $values;
			return $result;
		}
	}
}