<?php
/**
 * This is the Auth storage adapter for Sessions
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
class Saros_Auth_Storage_Session implements Saros_Auth_Storage_Interface
{
	const NAMESPACE = "Saros_Auth";

	const KEY = "identity";

	/**
	* The Saros_Session object we are using
	*
	* @var mixed
	*/
	protected $session;

	protected $namespace;

	protected $key;

	public function __construct($namespace = self::NAMESPACE, $key = self::KEY)
	{
		$this->namespace = $namespace;
		$this->key = $key;

		$this->session = new Saros_Session($namespace);
	}

	public function getIdentity()
	{
		return $this->session->key;
	}

	public function hasIdentity()
	{
		return isset($this->session->{$this->key});
	}

	public function writeIdentity($id)
	{
		$this->session->{$this->key} = $id;
	}

	public function clearIdentity()
	{
		unset($this->session->{$this->key};
	}
}