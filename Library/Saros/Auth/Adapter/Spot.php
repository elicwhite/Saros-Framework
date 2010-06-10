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

	protected $setCred = false;

	/**
	* Create a new Spot Auth adapter
	*
	* @param Spot_Mapper_Abstract $mapper the Mapper to authenticate against
	* @param string $identifierCol The column to use as the identity (username)
	* @param string $credentialCol The column that contains a credential (password)
	*
	* @throws Saros_Auth_Exception if $identifierCol is not defined in $mapper
	* @throws Saros_Auth_Exception if $credentialCol is not defined in $mapper
	*
	* @return Saros_Auth_Adapter_Spot
	*/
	public function __construct(Spot_Mapper_Abstract $mapper, $identifierCol, $credentialCol)
	{
		$this->mapper = $mapper;

		if (!$mapper->fieldExists($identifierCol))
			throw new Saros_Auth_Exception("Identifier column of '".$identifierCol."' is not defined in mapper.");

		if (!$mapper->fieldExists($credentialCol))
			throw new Saros_Auth_Exception("Credential column of '".$credentialCol."' is not defined in mapper.");

		$this->identifierCol = $identifierCol;
		$this->credentialCol = $credentialCol;
	}

	/**
	* Set the identifier and credential to authenticate
	*
	* @param mixed $identifier The identifier to authenticate
	* @param mixed $credential The credential to authenticate
	*/
	public function setCredential($identifier, $credential)
	{
		// Mark that we have run this function
		$this->setCred = true;

		$this->identifier = $identifier;
		$this->credential = $credential;
	}

	/**
	* Authenticate the request
	*
	* @throws Saros_Auth_Exception if setCredential hasn't been called
	* @return Saros_Auth_Result the result of the authentication
	*
	* @see Saros_Auth_Result
	*/
	public function authenticate()
	{
		if (!$this->setCred)
			throw new Saros_Auth_Exception("You must call setCredential before you can authenticate");

		// Get all the users with the identifier of $this->identifier.
		$user = $this->mapper->all(array(
							$this->identifierCol => $this->identifier
							))->execute();

		/**
		* @todo figure out which we need.
		* @todo Documentation needs to mention that we should ALWAYS compare based on the consts of Saros_Auth_Result
		*/
		if (!$user || count($user) == 0)
			$status = Saros_Auth_Result::UNKNOWN_USER;
		// If there is more than one user, its a problem
		elseif (count($user) > 1)
			$status = Saros_Auth_Result::AMBIGUOUS_ID;
		else
		{
			// We have exactly one user
			// We need to get the salt
			assert(count($user) == 1);
			$user = $user->first();

			$status = $this->validateUser($user);

		}

		return new Saros_Auth_Result($status, $user);
	}

	/**
	* Authenticate a single user entity
	*
	* @param Spot_Entity $user to authenticate
	* @return int a Saros_Auth_Result status flag representing the authentication attempt;
	*
	* @see Saros_Auth_Result
	*/
	public function validateUser(Spot_Entity $user)
	{
		// Combine the salt and credential and sha1 it. Check against credentialCol
		if($user->{$this->credentialCol} == $this->credential)
			$status = Saros_Auth_Result::SUCCESS;
		else
			$status = Saros_Auth_Result::FAILURE;

		return $status;
	}
}

