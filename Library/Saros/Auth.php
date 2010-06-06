<?php
/**
 * This is the main class to utilize Saros_Auth
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
class Saros_Auth
{

	/**
	* We are implementing the singleton pattern,
	* so we must keep track of a static instance
	* of this class
	*
	* @var Saros_Auth
	*/
	protected static $instance;

	protected $adapter = null;

	protected $storage = null;

	/**
	* Singleton Pattern: No constructing
	*/
	protected function __construct(){}

	/**
	* Singleton Pattern: No cloning
	*/
	protected function __clone(){}

	public static function getInstance()
	{
		if (is_null(self::$instance))
			self::$instance = new self();

		return self::$instance;
	}

	public function setAdapter(Saros_Auth_Adapter_Interface $adapter)
	{
		$this->adapter = $adapter;
		return $this;
	}

	public function getAdapter()
	{
		return $this->adapter;
	}

	public function setStorage(Saros_Auth_Storage_Interface $storage)
	{
		$this->storage = $storage;
	}

	public function getStorage()
	{
		if (is_null($this->storage))
			$this->storage = new Saros_Auth_Storage_Session();

		return $this->storage;
	}

	public function authenticate(Saros_Auth_Adapter_Interface $adapter = null)
	{
		if (!is_null($adapter))
			$this->setAdapter($adapter);

		if (is_null($this->adapter))
			throw new Saros_Auth_Exception("You must set an authentication adapter before attempting to authenticate.");

		$result = $this->adapter->authenticate();


		/*
		To be safe, we need to make sure we don't have an identity stored
		before we try to store a new one
		*/
		if ($this->hasIdentity())
			$this->clearIdentity();

		if ($result->isSuccess())
			$this->getStorage()->writeIdentity($result->getIdentity());

		return $result;
	}

	public function hasIdentity()
	{
		return $this->getStorage()->hasIdentity();
	}

	public function getIdentity()
	{
		$storage = $this->getStorage();
		if(!$storage->hasIdentity())
			return null;

		return $storage->getIdentity();
	}

	public function clearIdentity()
	{
		$this->getStorage()->clearIdentity();
	}

}