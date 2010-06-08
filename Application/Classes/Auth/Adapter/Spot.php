<?php
/**
 * This is the application specific Spot Auth Adapter.
 * It overrides the Default Spot Auth adapter.
 *
 * The difference between this adapter and the default adapter
 * is that this supports user-by-user salts specified by $saltCol;
 *
 * The password and the salt are combined and sha1'd
 *
 * sha1(credential+salt)
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
class Application_Classes_Auth_Adapter_Spot implements Saros_Auth_Adapter_Spot
{

	private $saltCol;

	public function __construct(Spot_Mapper_Abstract $mapper, $identifierCol, $credentialCol, $saltCol)
	{
		$this->mapper = $mapper;

		if (!is_string($identifierCol) || trim($identifierCol) == "")
			throw new Saros_Auth_Exception("Username Column must be a string. '".gettype($identifierCol)."' given.");

		if (!is_string($credentialCol) || trim($credentialCol) == "")
			throw new Saros_Auth_Exception("Password Column must be a string. '".gettype($credentialCol)."' given.");

		if (!is_string($saltCol) || trim($saltCol) == "")
			throw new Saros_Auth_Exception("Password Column must be a string. '".gettype($credentialCol)."' given.");

		$this->identifierCol = $identifierCol;
		$this->credentialCol = $credentialCol;
		$this->saltCol = $saltCol;
	}

	public function authenticate()
	{
		if (is_null($this->identifier) || is_null($this->credential))
			throw new Saros_Auth_Exception("You must call setCredential before you can authenticate");

		// Get all the users with the identifier of $this->identifier. Should only be one
		$user = $this->mapper->all(array(
							$this->identifierCol => $this->identifier
							));

		// If no user
		/**
		* @todo figure out which we need.
		*/
		if (!$user || count($user) == 0)
			$status = Saros_Auth_Result::UNKNOWN_USER;
		// If there is more than one user, its a problem
		elseif (count($user) > 1)
			$status = Saros_Auth_Result::AMBIGUOUS_ID_FAILURE;
		else
		{
			// We have exactly one user
			// We need to get the salt
			$salt = $user->{$this->saltCol};

			// Combine the salt and credential and sha1 it. Check against credentialCol
			if($user->{$this->credentialCol} == sha1($salt.$user->{$this->credential}))
				$status = Saros_Auth_Result::SUCCESS;
			else
				$status = Saros_Auth_Result::FAILURE;
		}

		return new Saros_Auth_Result($status, $user);
	}
}

