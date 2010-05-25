<?php
/**
 * This is the Auth adapter for Spot storage
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
class Saros_Auth_Adapter_Spot
{
	/**
	* The Spot_Adapter that is being used for storage
	*
	* @var Spot_Adapter
	*/
	protected $adapter;

	/**
	* The Spot_Mapper that is the data_source for the auth
	* information
	*
	* @var Spot_Mapper
	*/
	protected $mapper;

	/**
	* The name of the column that contains the username field
	* in the auth mapper
	*
	* @var string
	*/
	protected $usernameCol;

	/**
	* The name of the column that contains the password field
	* in the auth mapper
	*
	* @var string
	*/
	protected $passwordCol;

	/**
	* The name of the column that contains the salt field
	* in the auth mapper; This is an optional field, and may
	* not be set.
	*
	* @var string
	*/
	protected $saltCol;
/**
* This will need to take a Spot_Adapter, Spot_Mapper, username column
* password column, and an optional salt column
*/
	public function __construct(Spot_Adapter $adapter, Spot_Mapper $mapper, $usernameCol, $passwordCol, $saltCol = "")
	{
		$this->adapter = $adapter;
		$this->mapper = $mapper;

		if (!is_string($usernameCol))
			throw new Saros_Auth_Exception("Username Column must be a string. '".gettype($usernameCol)."' given.");

		if (!is_string($passwordCol))
			throw new Saros_Auth_Exception("Password Column must be a string. '".gettype($passwordCol)."' given.");

		if (!is_string($saltCol))
			throw new Saros_Auth_Exception("Salt Column must be a string. '".gettype($saltCol)."' given.");

		$this->usernameCol = $usernameCol;
		$this->passwordCol = $passwordCol;
		$this->saltCol = $saltCol;
	}
}