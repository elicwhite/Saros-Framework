<?php
/**
 * This class provides an OOP abstraction layer
 * to the underlying PHP sessions. Provides namespace
 * support to restrict name collisions.
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
class Saros_Session implements ArrayAccess, Countable, IteratorAggregate
{
	// The namespace of this instance
	private $namespace;

	private $initNamespaces = array();

	// A boolean flag of whether the session has already been started
	private static $sessionStarted;

	/**
	* Create a new namespaced Session object
	*
	* @param mixed $namespace the namespace to use
	* @param mixed $allowMultiple If true, you can only have one instance of Saros_Session tied
	* 									to the specified namespace.
	* 							  If false, you can have unlimited instances to the same
	* 									namespace.
	*/
	public function __constructor($namespace, $allowMultiple = false)
	{
		if (!is_string($namespace) || trim($namespace) == "")
			throw new Saros_Session_Exception("The session namespace must be a non-empty string, '".gettype($namespace)."' given.");

		if (!$allowMultiple && isset($initNamespaces[$namespace]))
			throw new Saros_Session_Exception("Only one instance of Saros_Session can be defined with the namespace '".$namespace."'");

		$this->namespace = $namespace;

		self::$initNamespaces[$this->namespace] = true;

		self::start();
	}

	/**
	* Call this function to explicitly start a session
	*
	* @throws Saros_Session_Exception if the session has already been started,
	* 									or if headers have already been sent
	*
	*/
	public static function start()
	{
		if (self::$sessionStarted)
			throw new Saros_Session_Exception("The session has already been started");

		$filename = "";
		$linenum = "";
		if(headers_sent($filename, $linenum))
			throw new Saros_Session_Exception("Headers already sent in '".$filename."' on line '".$linenum."'");

		session_start();

		self::$sessionStarted = true;
	}


	/*
	* PHP 5 Magic Methods
	*/
	public function __get($key)
	{
		if (!isset($_SESSION['_saros'][$namespace][$key]))
			throw new Saros_Session_Exception("The key '".$key."' has not been defined for session namespace '".$namespace."'");

		return $_SESSION['_saros'][$this->namespace][$key];
	}

	public function __set($key, $value)
	{
		$_SESSION['_saros'][$this->namespace][$key] = $value;
	}

	public function __isset($key)
	{
		return isset($_SESSION['_saros'][$this->namespace][$key]);
	}

	public function __unset($key)
	{
		unset($_SESSION['_saros'][$this->namespace][$key]);
	}

	/*
	* SPL - Array Access
	*/
	public function offsetGet($key)
	{
		return $this->__get($key);
	}
	public function offsetSet($key, $value)
	{
		return $this->__set($key, $value);
	}
	public function offsetExists($key)
	{
		return $this->__isset($key);
	}
	public function offsetUnset($key)
	{
		$this->__unset($key);
	}

	/*
	* SPL - Countable
	*/
	public function count()
	{
		return count($_SESSION['_saros'][$this->namespace]);
	}

	/*
	* SPL - IteratorAggregate
	*/
	public function getIterator()
	{
		return new ArrayIterator($_SESSION['_saros'][$this->namespace]);
	}

}
