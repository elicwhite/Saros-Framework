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
 * Creates a database connection object
 *
 */
class Library_Database
{
	// The adapter connection we are using
	public $adapter;
	private $adapters = array(
		"mysql" => "Library_Database_Adapter_Mysql"
	);
	
	/**
	 * An array of the tables we have initialized
	 * Don't preload tables to not waste memory and resources
	 */
	private $initTables = array();
	
	
	function __construct($dbType, $host, $user, $pass, $dbName)
	{
		// Convert the requested database type to lowercase
		$type = strtolower($dbType);
		// And check if we have defined that adapter to exist
		if (!in_array($type, array_keys($this->adapters)))
			throw new Exception("There is no adapter defined for ".$dbType);
			
		$this->adapter = new $this->adapters[$type]($host, $dbName, $user, $pass);
		//$this->adapter->connect($host, $user, $pass, $dbName);
	}
	
	// Called when we are accessing a table
	public function __get($key)
	{
		$table = ucfirst($key);
		if (!in_array($table, array_keys($this->initTables) ))
		{
			$className = "Application_Mappers_".$table;
			// We haven't already initialized the table, lets do that now
			if (!class_exists($className))
				throw new Exception("The mapper ".$table." hasn't been defined.");
				
			$class = new $className($this->adapter);
			//$class->setAdapter($this->adapter);
			
			$this->initTables[$table] = $class;
		}
		
		return $this->initTables[$table];
	}
}
?>