<?php
/**
 * Auth Result Object
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Saros_Auth_Result
{

	const SUCCESS = 1;
	const FAILURE = 0;
	const UNKNOWN_FAILURE = -1;

	protected $resultCode;
	protected $identity;

	public function __construct($code, $identity)
	{
		if ($code <= self::UNKNOWN_FAILURE)
			$code = self::FAILURE;

		$this->resultCode = $code;
		$this->identity = $identity;
	}

	public function getCode()
	{
		return $this->resultCode;
	}

	public function getIdentity()
	{
		return $this->identity;
	}

	public function isSuccess()
	{
		return $this->code == self::SUCCESS;
	}
}