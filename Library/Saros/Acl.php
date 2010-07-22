<?php
class Saros_Acl
{
	protected $adapter;

	protected $permissions = null;

	public function __construct(Saros_Acl_Adapter_Interface $adapter)
	{
		$this->adapter = $adapter;
	}

	public function populate(Saros_Auth_Identity_Interface $identity)
	{
		$identifier = $identity->getIdentifier();

		// This will contain all of the permissions the user has been specified
		$permissions = array();

		// assuming that $identity has an id column
		$userPermissions = $this->adapter->getUserPermissions($identifier); //$db->query("SELECT * FROM UsersPermissions WHERE UserId = @0", $identity->id);

		// Go through each user explicit permission
		foreach($userPermissions as $permissionName => $values) {
			// $permission["name"] could be something like "Article1"
			// $permission["values"] could be something like ""View:true,NewTopic:true,Reply:true,EditSelf:true""

			// These are all the access permissions with that permission name
			$access = array();

			// Store that array of permissions in the overall array
			$permissions[$permissionName] = $values;
		}

		// These are all of the permissions specified to the user by roles
		$rolesPermissions = array();

		// Get the permissions on the chains of roles the user is in
		$roles = $this->adapter->getUserRoles($identifier);
		foreach($roles as $role) {

			// This is the overall result for the heirarchy of the current role
			// Something like
			// [article1] =>
			//				[view] => [true]
			//				[edit] => [true]
			//				[delete] => [true]
			$roleAccess = array();

			$parents = $this->adapter->getHierarchy($role);
  			foreach($parents as $parent) {
  				// Foreach node closer to the role the user is in
  				// get the permission
  				//while($permission = getRolesPermissions($parent);
  				$rolePermissions = $this->adapter->getRolePermissions($parent);//$db->query("SELECT * FROM RolesPermissions WHERE roleId = @0", $parent);

  				if ($rolePermissions != null)
  				{
					foreach($rolePermissions as $name=>$values)
					{
						// If this key hasn't been initialized, then do it
						if (!isset($rolesPermissions[$name]))
						{
							$rolesPermissions[$name] = array();
						}
						foreach($values as $key=>$value)
						{
							$rolesPermissions[$name][$key] = $value;
						}
					}
				}
			}
		}


		// Right now if we get two different answers from different chains, then the result is not gaurenteed.
		// Aka: Dont have ambiguous ACL trees
		foreach($permissions as $name => $values)
		{
			if (!isset($rolesPermissions[$name]))
			{
				$rolesPermissions[$name] = array();
			}

			foreach($values as $key=>$value)
			{
				$rolesPermissions[$name][$key] = $value;
			}
		}
		$this->permissions = $rolesPermissions;
	}

	public function getPermissions()
	{
		return $this->permissions;
	}

	public function can($name, $value)
	{
		if ($this->permissions == null)
			throw new Saros_Acl_Exception("The ACL was not populated");

		if (isset($this->permissions[$name][$value]))
			return $this->permissions[$name][$value];
		else
			return false;
	}
}