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
 * Similar to Library_Core_Registry but used only for configuration values
 *
 */
class Library_Config implements ArrayAccess
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
			throw new Exception("The config key ".$index." is not defined.");
			
	    return $this->vars[$index];
	}
	
	
	// SPL - ArrayAccess Functions
	public function offsetExists($key)
	{
		/**
		 * We want to know if this item exists.
		 * It does if we can get it
		 */
		return (isset($this->vars[$key]));
	}
	public function offsetGet($key)
	{
		return $this->$key; // Calls __get
	}
	public function offsetSet($key, $value)
	{
		$this->$key = $value;
	}
	public function offsetUnset($key)
	{
		unset($this->vars[$key]);
	}
}
?>