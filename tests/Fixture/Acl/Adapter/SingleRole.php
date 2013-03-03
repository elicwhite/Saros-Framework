<?php
namespace Fixture\Acl\Adapter;

class SingleRole implements \Saros\Acl\Adapter\IAdapter
{
	public function getUserPermissions()
	{
		return array();
	}
	public function getUsersRoles()
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

	public function addRole($roleName) {}
	public function addRoleToRole($roleName, $newParent) {}
	public function addUserToRole($user, $roleName) {}
	public function deleteRole($roleName) {}
}