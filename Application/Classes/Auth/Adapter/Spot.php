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
class Application_Classes_Auth_Adapter_Spot extends Saros_Auth_Adapter_Spot_Plain
{

	private $saltCol;

	/**
	*
	* @param Spot_Mapper_Abstract $mapper
	* @param mixed $identifierCol
	* @param mixed $credentialCol
	* @param mixed $saltCol
	* @return Application_Classes_Auth_Adapter_Spot
	*/
	public function __construct(Spot_Mapper_Abstract $mapper, $identifierCol, $credentialCol, $saltCol)
	{
		parent::__construct($mapper, $identifierCol, $credentialCol);

		if (!$mapper->fieldExists($saltCol))
			throw new Saros_Auth_Exception("Salt column of '".$saltCol."' is not defined in mapper.");

		$this->saltCol = $saltCol;
	}

	public function validateUser(Spot_Entity $user)
	{
		$salt = $user->{$this->saltCol};

		// Combine the salt and credential and sha1 it. Check against credentialCol
		if($user->{$this->credentialCol} == sha1($salt.$this->credential))
			$status = Saros_Auth_Result::SUCCESS;
		else
			$status = Saros_Auth_Result::FAILURE;

		return $status;
	}
}

