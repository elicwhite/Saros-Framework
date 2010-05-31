<?php
/**
 * This is the Auth adapter for Spot Compatible Databases
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
class Saros_Auth_Adapter_Spot implements Saros_Auth_Adapter_Interface
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
	protected $identifierCol;

	/**
	* The name of the column that contains the password field
	* in the auth mapper
	*
	* @var string
	*/
	protected $credentialCol;


	protected $identifier;
	protected $credential;

/**
* This will need to take an initialized Spot_Mapper, username column
* password column, and an optional salt column
*/
	public function __construct(Spot_Mapper_Abstract $mapper, $identifierCol, $credentialCol, $identifier, $credential)
	{
		$this->adapter = $adapter;
		$this->mapper = $mapper;

		if (!is_string($identifierCol) || trim($identifierCol) == "")
			throw new Saros_Auth_Exception("Username Column must be a string. '".gettype($identifierCol)."' given.");

		if (!is_string($credentialCol) || trim($credentialCol) == "")
			throw new Saros_Auth_Exception("Password Column must be a string. '".gettype($credentialCol)."' given.");

		$this->identifierCol = $identifierCol;
		$this->credentialCol = $credentialCol;

		$this->identifier = $identifier;
		$this->credential = $credential;
	}

	public function authenticate()
	{
		// Get all the users with the identifier of $this->identifier. Should only be one
		$user = $mapper->first(array(
							$this->identifierCol => $this->identifier,
							$this->credentialCol => $this->credential
							));

		$status = Saros_Auth_Result::SUCCESS;
		if (!$user)
			$status = Saros_Auth_Result::FAILURE;

		return new Saros_Auth_Result($status, $this->identifier);
	}
}