<?php
/**
 * This is the common interface that all rolemanagers must implement
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 *
 */
interface Saros_Acl_RoleManager_Interface
{
	// Add a role
	public function addRole($roleName);
	public function addRoleToRole($roleName, $newParent);
	public function addUserToRole($user, $roleName);

	public function deleteRole($roleName);

	// Get the role names that the user is in
	public function getUsersRoles();

	// get the permissions defined for the role specified by $roleName
	public function getRolePermissions($roleName);

	// get the permissions defined explicitly for that user
	public function getUserPermissions();

	// Get the heirarchy from root to node of $roleId. This must include $roleId as the last element in the array
	public function getHierarchy($roleId);



}