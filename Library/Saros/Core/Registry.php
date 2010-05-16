<?php
/**
 * This is the registry class. It stores all important links and classes
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Saros_Core_Registry implements ArrayAccess
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