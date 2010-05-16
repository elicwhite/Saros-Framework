<?php
/**
 * Creates a database connection object
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Saros_Database
{
	// The adapter connection we are using
	public $adapter;
	private $adapters = array(
		"mysql" => "Saros_Database_Adapter_Mysql"
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