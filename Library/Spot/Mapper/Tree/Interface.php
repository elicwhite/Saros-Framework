<?php
/**
 * Copyright Eli White & SaroSoftware 2010
 * Last Modified: 4/29/2010
 * 
 * This file is part of Saros Framework.
 * 
 * Saros Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Saros Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Saros Framework.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * This interface defines all the functionality that a Tree mapper must implement
 */
interface Library_Database_Mapper_Tree_Interface
{
	/**
     * Save the entity in the mapper
     * 
     * @param array|Library_Database_Entity $entity An array of values for the entity, or the entity object to save.
     * @param Library_Database_Entity $parent The parent $entity will be a child of
     * @param int $childNum The child number we want to be. Negative numbers are allowed,
     * 							0 is the first child, -1 is the last child.
     * 
     * @see Library_Database_Entity::data()
     *
     */
	public function save($entity, $parent = null, $childNum = -1);
	
	/**
	 * Delete an entity from the mapper
	 *
	 * @param mixed $entity Either a Library_Database_Entity instance of the entity to delete,
	 * 						 or the primary key value of the entity to delete.
	 * @param boolean $keepChildren Whether the children of $entity should be kept. If true
	 * 								 then the children will be given the parent that $entity had.
	 * 								 If false, then $entity and all of it's descendents will be deleted
	 */
	public function delete($entity, $keepChildren = true);
	
	/**
	 * Get all of the children of $entity
	 *
	 * @param mixed $entity Either a Library_Database_Entity instance of the entity,
	 * 						 or the primary key value of the entity.
	 * @param boolean $directChildren If true, will get all of the children with a parent of $entity,
	 * 									If false, will return all of $entity's children and descendents.
	 * @return Library_Database_EntitySet A collection of matching children
	 * 
	 */
	public function getChildren($entity, $directChildren = true);
	
	/**
	 * Returns the number of children $node has
	 *
	 * @param mixed $entity Either a Library_Database_Entity instance of the entity,
	 * 						 or the primary key value of the entity.
	 * @param boolean $directChildren If true, only the direct children of the node should be counted.
	 * 									If false, all children and descendents will be counted.
	 */
	public function numChildren($entity, $directChildren = true);

	/**
	 * Gets a path from a root to $entity
	 *
	 * @param mixed $entity Either a Library_Database_Entity instance of the entity,
	 * 						 or the primary key value of the entity.
	 * @return Library_Database_EntitySet A collection with entities matching the path from the root to the node.
	 */
	public function getPath($entity);
	
	/**
	 * Move an element and it's children, under element $target_id as the $childNum'th child of that element
	 *
	 * @param mixed $entity Either a Library_Database_Entity instance of the entity,
	 * 						 or the primary key value of the entity.
	 * @param int $parent Either a Library_Database_Entity instance of the parent entity,
	 * 						 or the primary key value of the parent.
     * @param int $childNum The child number we want to be. Negative numbers are allowed,
     * 							0 is the first child, -1 is the last child.
	 * 				
	 */
	public function move($entity, $parent, $childNum = 0);
	
	/**
	 * Moves an entity to be one child earlier. If entity is already child number 0,
	 * no action is made.
	 *
	 * @param mixed $entity Either a Library_Database_Entity instance of the entity,
	 * 						 or the primary key value of the entity.
	 */
	public function moveNodeUp($entiy);
	
	/**
	 * Moves an entity to be one child later. If entity is already the last child,
	 * no action is made.
	 *
	 * @param mixed $entity Either a Library_Database_Entity instance of the entity,
	 * 						 or the primary key value of the entity.
	 */
	public function moveNodeDown($entiy);
	
	/**
	 * Gets the entities that have no parent connections
	 * 
	 * @return All of the entities that are roots (have no parent nodes)
	 */
	public function getRoots();
	
	/**
	 * Formats a tree with a root given by $entity
	 *
	 * @param mixed $root Either a Library_Database_Entity instance,
	 * 						 or the primary key value of the entity to be used as the root.
	 */
	public function formatTree($root);
	
	/**
	 * Verifies that a tree is valid. 
	 *
	 * @param unknown_type $root
	 */
	public function isValid($root);
	
	
	/*
	reorder()
		Renumbers the left and right numbers in the case that they have become corrupted
		Does not modify the parent link
	*/
}
?>