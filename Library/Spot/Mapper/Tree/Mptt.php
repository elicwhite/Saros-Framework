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
	// Field list
	public $id = array("type" => "int", "primary" => true, "serial" => true);
	public $mptt_parent = array("type" => "int");
	public $mptt_left = array("type" => "int");
	public $mptt_right = array("type" => "int");
	
	// Parent relationship
    public $parent = array(
        'type' => 'relation',
        'relation' => 'HasOne',
        'mapper' => "Application_Mappers_TestMptt",
        'where' => array('mptt_parent' => ':entity.id')
        // Means the current mappers mptt_parent column = currently loaded Post entity id
    );
	
	public function add($entity, $parent = null, $child_num = -1)
	{		
		if(is_array($entity)) {
			$entity = $this->get()->data($entity);
		}

		// Make sure our entity is an mptt node entity
		$this->checkEntity($entity);
			
			
		if (!is_null($parent))
		{
			// If parent isn't null, it has to be the defaultEntity type
			$this->checkEntity($parent);
			
			// Set the entity's parent id to be the primary key
			$entity->mptt_parent = $this->primaryKey($parent);
		}
		
		if (!is_int($child_num))
			throw new $this->_exceptionClass("Child number must be an integer");
		
		// Initialize some variables
		$left = 0;
		$right = 0;		
		
		/*
		If we have no elements, then we should add $entity to the
		tree with a left of 0 and right of 1
		
		TODO: THIS ISN'T TRUE! If you have a multi root tree.
		Need to find the last element in the tree, and add one to the right to find our left
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
			 * 	and we have wrapped from behind to be before the 0'th element.
			 * 
			 * 0,1,2,3 and -5 is specified 
			 * 0,1 and -3 is specified
			 * abs(childNum) > numchildren + 2
			 * no children and -1 is specified (should be 0)
			 *
			 */
			if ($child_num == 0 || ($child_num < 0 && abs($child_num) > $numChildren) )
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
		}
		
		/**
		 * We have a left and a right defined now, we need to shift everything else over
		 * 
		 * Increase every node with a left greater than sibling right by 2
		 */
		$leftToFix = $this->all(
			array(
				"mptt_left >=" => $left,
				)
			);
		foreach($leftToFix as $node)
		{
			$node->mptt_left += 2;
			$this->save($node);
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