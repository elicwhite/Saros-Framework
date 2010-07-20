<?php
  /*
  users can be in multiple roles
  permissions can be applied to roles and users

  tables:

  Users:
  userId	name

  Roles:
  roleId	name	lid		rid

  RolesPermissions:
  roleId	name	values

  UsersRoles
  userId	roleId

  UsersPermissions:
  userId	name	values




  Content:
  Users:
  1		Eli
  2		Fred
  3		Lilly

  Roles
  1		Banned		1 12
  2		Guests		2 11
  3		Members		3 10
  4		VIP			4 5
  5		Moderators	6 9
  6 	Admin		7 8

  			1	banned 12

  			2	guests 11

  			3	Members 10

  		4	Vip  5		6 Moderators 9

  						7	Admin  8

  RolesPermissions:
  roleId 	name	values
  2			Board	View:true
  3			Board	Edit:true,New:true
  4			Secret	View:true
  4			Chat	View:true
  5			Chat	View:true,Delete:true
  6			Admin	View:true

  UsersRoles
  userId	roleId
  1			6
  2			4
  2			5
  3			3

  UsersPermissions:
  userId	name	values
  2			Chat	Delete:false

  $acl->can("Eli", "Admin", "View");
  	get the userId for "Eli" (1)
  	Get all of the rows from UsersPermissions with a userId of 1 (0 rows)
  	set canDo = false
  	get the heirarchy of roles for user 1 ((1)Banned->(2)Guests->(3)Members->(5)Moderators->(6)Admin)
  		Get all of the rows from RolesPermissions for the role 1 and name "Admin" (0 rows)
  		Get all of the rows from RolesPermissions for the role 2 and name "Admin" (0 rows)
  		Get all of the rows from RolesPermissions for the role 3 and name "Admin" (0 rows)
  		Get all of the rows from RolesPermissions for the role 5 and name "Admin" (0 rows)
  		Get all of the rows from RolesPermissions for the role 6 and name "Admin" (1 row)
  			set canDo = value of row for "View" (true)
  	return canDo(true)

  	Generic:
  	$acl->can($user, $perm, $value)
  		$userId = getUserId($user)
  		$rows = get all rows from UsersPermissions where userId = $userId and name = $perm
  		foreach($row in $rows)
  			if ($row->$value == false)
  				return false;
  		$canDo = false;
  		$results = array();
  		$roles = get all the rows from UsersRoles joined with roles where userId = $userId
  		foreach($role in $roles)
  			$parents = "SELECT Id FROM Roles WHERE lid <= $role->lid AND rid >= $role->rid ORDER BY Id ASC"
  			$result = false;
  			foreach($parent in $parents)
  				$permission = "SELECT values FROM RolesPermissions WHERE roleId = $parent AND name = $perm";
  				if (isset($permission->$value))
  					$result = $permission->$value;
  			$results[] = $result;

  		for($i = 1; $i < count($results); $i++)
  		{
  			if ($results[$i-1] != $results[i])
  				throw new Exception("Ambiguous access request for ".$user.", ".$role" . ", "."$permission);
  		}
  		return $results[0];

  	Interface Generic:
  	 */
  	$acl->can($userId, $perm, $value)
  		// Get permissions directly applicable to the user
  		$userPermissions = getUserPermissions($userId, $perm)
  		foreach($perm in $userPermissions)
  			// If the permission specifices the permission we are looking for with a deny, then the result is deny
  			if (!$perm->$value)
  				return false;

  		// This is all of the results for all the paths to the roles the user is in
  		$results = array();
  		$roles = getUserRoles($userId);
  		foreach($role in $roles)
  			// For each role hierarchy we start out with a deny
  			$result = false;
  			$parents = getHierarchy($role);
  			foreach($parent in $parents)
  				// Foreach node closer to the role the user is in
  				// get the permission
  				$permission = getRolePermission($parent, $perm);
  				if (isset($permission->$value))
  					// If the permission is specified, set the result for this path
  					$result = $permission->$value;

  			// Add the path for that hierarchy chain to an array
  			$results[] = $result;

  		// If we got different results from different chains, then something is ambiguous
  		for($i = 1; $i < count($results); $i++)
  		{
  			if ($results[$i-1] != $results[i])
  				throw new Exception("Ambiguous access request for ".$user.", ".$role" . ", "."$permission);
  		}
  		return $results[0];


?>
