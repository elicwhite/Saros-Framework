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
 * This is the MPTT tree mapper class. This provides functionality for a mapper
 * to utilize the mptt storage mechanism in the database.
 */
abstract class Library_Database_Mapper_Tree_Mptt extends Library_Database_Mapper_Abstract
{
	protected $_defaultEntity = "Library_Database_Entity_Tree_Mptt";
	
	// Field list
	public $mptt_parent = array("type" => "int");
	public $mptt_left = array("type" => "int");
	public $mptt_right = array("type" => "int");
	
	public function add($entity, $parent = null, $child_num = -1)
	{		
		if(is_array($entity)) {
			$entity = $this->get()->data($entity);
		}

		// Make sure our entity is an mptt node entity
		$this->checkEntity($entity);
				
		if (!is_null($parent))
		{
			$this->checkEntity($parent);
			$entity->mptt_parent = $this->primaryKey($parent);
		}
		
		
		// Make sure our parent is an mptt node entity

		
		if (!is_int($child_num))
			throw new Exception("Child number must be an integer");
		
		// Initialize some variables
		$left = 0;
		$right = 0;		
		
		/*
		If we have no elements, then we should add $data to the
		tree with a left of 0 and right of 1
		*/
		if (is_null($parent))
		{
			$left = 0;
			$right = 1;	
		}
		else 
		{
			// A parent was specified
			$children = $this->getChildren($parent); 
			
			 // this is used in a bunch of places
			$numChildren = count($children);
			
			// If the parent doesn't have any children, we must be child 0
			if ($numChildren == 0)
				$child_num = 0;
				
			/*
				If $parent has no children OR
				we are trying to be child number that is less than 0 OR
				more than the next child
				
				Then we must be the next child
	
				
				What if we want to be the -1 child (last child)
				4-(-1) = 5 (should be 4) 4-1+1 = 4
				4-(-2) = 6 (should be 3) 4-2+1 = 3
				4-(-3) = 7 (should be 2) 4-3+1 = 2
				
				if $child_num is 0, it should be first
				if $child_num is HUGE, it should be last
				if $child_num is negative, it should count backwards from the end
				
				
				if we have 4 children, and we want to be the 5th child (0 based indexing
				makes $num_children 4) or greater then we should be the last child
				4 >= 4 = 0,1,2,3
				
				4 >= 4
			*/
			if ($child_num > $numChildren)
			{
				$child_num = $numChildren;	
			}
			
			/**
			 * If our child is 0, it is first
			 * It is also first if we have specified a negative child_num
			 * 	and we are before the 0'th element.
			 * 
			 * 0,1,2,3 and -6 is specified 
			 * 0,1 and -4 is specified
			 * abs(child) > numchildren + 2
			 * no children and -1 is specified (should be 0)
			 *
			 */
			if ($child_num == 0 || ($child_num < 0 && abs($child_num) > $numChildren + 2) )
			{
				
				$left = $parent->mptt_left + 1;
				$right = $left+1;
			}
			else
			{
				assert($child_num != 0);
				// <0 if we are inserting from the back (-1 is the last child)
				if ($child_num < 0)
				{
					/*
					we are inserting from the back, lets figure out
					a positive integer so we can have code reuse
					
					See the above math to see examples of the following line
					*/
					$child_num = $numChildren - abs($child_num) + 1;
				}
				
				// >0 if we are trying to insert into the middle of parent's children
				
				$prevChild = $children[$child_num - 1];
				
				$left = $prevChild->mptt_right +1;
				$right = $left + 1;
			}
			
			// Increase every node with a right greater than $prevChild.right by 2
			$rightToFix = $this->all(
				array(
					"mptt_right >=" => $left,
					)
				);
			foreach($rightToFix as $node)
			{
				$node->mptt_right += 2;
				$this->save($node);
			}
			
			// Increase every node with a left greater than sibling right by 2
			$leftToFix = $this->all(
				array(
					"mptt_left >=" => $left,
					)
				);
			foreach($rightToFix as $node)
			{
				$node->mptt_left += 2;
				$this->save($node);
			}
		}
		$entity->mptt_left = $left;
		$entity->mptt_right = $right;
		
		//print_r($entity);
		$this->save($entity);
	}
	
	public function getParent($entity)
	{
		$this->checkEntity($entity);
		
		return $this->get($entity->mptt_parent);// SELECT * FROM table WHERE `id` = parent_id
		//return $node->parent;
	}
	
	function getChildren($entity, $directChildren = true)
	{
		$this->checkEntity($entity);
		
		$children = array();

		if ($directChildren)
		{		
			return $this->all(
				array(
					"mptt_parent" => $this->primaryKey($entity)
					)
				)->execute();
		}
							
		// Otherwise we want all the children of this node
		return $this->all(
			array(
				$this->mptt_left." >" => $entity->mptt_left,
				$this->mptt_right." <" => $entity->mptt_right
				)
			)->execute();
	}
}
?>