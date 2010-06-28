<?php
/**
* This file should be inherited when testing controllers
*/
abstract class Saros_Test_Controllers_TestCase extends PHPUnit_Framework_TestCase
{
	protected $object;
	/**
	* This can be overridden if needed, but overriding
	* methods should ALWAYS call parent::setUp();
	*
	*/
	public function setUp()
	{
		// We are assuming that every test that inherits from this
		// will be testing a class that is the name of the test but with
		// Test_ removed
		$className = get_class($this);
		$className = substr($className, 5);
		$this->object = new $className();

		// Create a new registry of variables
		$registry = new Saros_Core_Registry();

		$this->init();
	}

	public function init()
	{

	}
}