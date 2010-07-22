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
		// This is the unique identifier for the identity that we will be passing around
		$identifier = $identity->getIdentifier();

		// This will contain all of the permissions the user has been specified
		$userPermissions = $this->getUserPermissions($identifier);

		$rolesPermissions = $this->getUserRolesPermissions($identifier);

		// Right now if we get two different answers from different chains, then the result is not gaurenteed.
		// Aka: Dont have ambiguous ACL trees
		$this->permissions = $this->mergePermissions($rolesPermissions, $userPermissions);
	}

	public function getPermissions()
	{
		return $this->permissions;
	}

	public function can($name, $value)
	{
		// An empty array is == to null
		if ($this->permissions === null)
			throw new Saros_Acl_Exception("The ACL was not populated");

		if (isset($this->permissions[$name][$value]))
			return $this->permissions[$name][$value];
		else
			return false;
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
		$rolesPermissions = array();

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
			$rolesAccess = array();

			// get an array of roles that leads to to $role
			$parents = $this->adapter->getHierarchy($role);

			// Go through each role in the chain, starting at the root
  			foreach($parents as $parent)
  			{
  				// For each node closer to the role the user is in
  				// get the permission
  				$rolePermissions = $this->adapter->getRolePermissions($parent);

  				// And merge those permissions into the permissions for this chain
  				$rolesAccess = $this->mergePermissions($rolesAccess, $rolePermissions);
			}
			// Merge the permissions for this chain into the permissions for the overall roles
			$rolesPermissions = $this->mergePermissions($rolesPermissions, $rolesAccess);
		}

		return $rolesPermissions;
	}

	// This merges two arrays of permissions. Every value in $overriding will over ride a permission
	// value that is defined in $total
	protected function mergePermissions($total, $overriding)
	{
		foreach($overriding as $name=>$values)
		{
			// If this key hasn't been initialized, then do it
			if (!isset($total[$name]))
			{
				$total[$name] = array();
			}
			foreach($values as $key=>$value)
			{
				$total[$name][$key] = $value;
			}
		}
		// @ToDo: Does modifying arrays do it in place by default?
		return $total;
	}
}