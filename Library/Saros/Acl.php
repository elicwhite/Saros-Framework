<?php
class Saros_Acl
{
	protected $adapter;

	public function __construct(Saros_Acl_Adapter_Interface $adapter)
	{
		$this->adapter = $adapter;
	}

	/**
	* Populate the acl tree for a user
	*
	* @param mixed $identitifier The unique identifier for the user
	*/
	public function populate($identifier)
	{
		$rolesPermissions = $this->getUserRolesPermissions($identifier);

		$permissions = new Saros_Acl_Permission_Set($rolesPermissions);

		// This will contain all of the permissions the user has been specified
		$userPermissions = $this->getUserPermissions($identifier);

		$permissions->merge($userPermissions);

		// Right now if we get two different answers from different chains, then the result is not gaurenteed.
		// Aka: Dont have ambiguous ACL trees
		//$this->permissions = $this->mergePermissions($rolesPermissions, $userPermissions);

		return $permissions;
	}

	protected function getUserPermissions($identifier)
	{
		// This will contain all of the permissions the user has been specified
		$userPermissions = array();

		$permissions = $this->adapter->getUserPermissions($identifier);

		// Go through each user explicit permission
		foreach($permissions as $permissionName => $values) {

			$userPermissions[$permissionName] = $values;
		}

		return $userPermissions;
	}

	protected function getUserRolesPermissions($identifier)
	{
		// These are all of the permissions specified to the user by roles
		$rolesPermissions = new Saros_Acl_Permission_Set();

		// Get the permissions on the chains of roles the user is in
		$roles = $this->adapter->getUserRoles($identifier);

		// Go through each role the user is in
		foreach($roles as $role)
		{
			// This is the overall result for the heirarchy of the current role
			// Something like
			// [article1] =>
			//				[view] => [true]
			//				[edit] => [true]
			//				[delete] => [true]
			$rolesAccess = new Saros_Acl_Permission_Set();

			// get an array of roles that leads to to $role
			$parents = $this->adapter->getHierarchy($role);

			// Go through each role in the chain, starting at the root
  			foreach($parents as $parent)
  			{
  				// For each node closer to the role the user is in
  				// get the permission
  				$rolePermissions = $this->adapter->getRolePermissions($parent);

  				// And merge those permissions into the permissions for this chain
  				$rolesAccess->merge($rolePermissions);
			}
			// Merge the permissions for this chain into the permissions for the overall roles
			$rolesPermissions->merge($rolesAccess);
		}

		return $rolesPermissions;
	}
}