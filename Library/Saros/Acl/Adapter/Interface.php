<?php
/**
 * This is the common interface that all acl adapters must implement
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
interface Saros_Acl_Adapter_Interface
{

	// get the permissions defined explicitly for that user
	public function getUserPermissions();

	// Get the role identifier the user is in
	public function getUserRoles();

	// Get the heirarchy from root to node of $roleId
	public function getHierarchy($roleId);

	// Get the permissions defined for a role specified by the role identifer
	public function getRolePermissions($roleId);

}