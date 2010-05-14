<?php
/**
 * Copyright Eli White & SaroSoftware 2010
 * Last Modified: 3/26/2010
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
 * This is the registry class. It stores all important links and classes
 */
class Saros_Core_Registry
{
	// The variable array we will use
	private $vars;
	
	/*
	 * These two functions allow us to get and set variables into our vars array.
	 * This means that this class can store virtually anything
	 */
	public function __set($index, $value)
	{
	    $this->vars[$index] = $value;
	}
	public function __get($index)
	{
		if (!isset($this->vars[$index]))
			throw new Saros_Core_Exception("The key: ".$index." is not defined in the registry.");
			
	    return $this->vars[$index];
	}
}
?>