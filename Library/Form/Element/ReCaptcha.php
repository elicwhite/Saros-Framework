<?php
/**
 * Copyright Eli White & SaroSoftware 2010
 * Last Modified: 3/26/2010
 * 
 * This file is part of Saros Framework.
 * 
 * Saros Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Saros Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Saros Framework.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
class Library_Form_Element_ReCaptcha extends Library_Form_Element
{
	// Recaptcha object
	protected $captcha;
	
	protected $errorMessages = array(
		"incorrect-captcha-sol" => "The CAPTCHA solution was incorrect.",
		"captcha-error"			=> "An error occured with the captcha."
	);
		
	public function __construct()
	{
		$this->recaptcha = new Library_Captcha_ReCaptcha();
		$this->name = "recaptcha_response_field";
	}
	
	// We can't set a name on captchas
	public function setName()
	{
	}
	
	public function setPublicKey($key)
	{
		$this->recaptcha->setPublicKey($key);
		return $this;
	}
	public function setPrivateKey($key)
	{
		$this->recaptcha->setPrivateKey($key);
		return $this;
	}
	
	public function addValidator()
	{
		throw new Exception("You cannot add validators to ReCaptcha elements.");
	}
	
	/*
		Validate the value of the element
	*/
	public function validate()
	{
		//var_dump($this->getValue());
		if ($this->getValue() && isset($_POST["recaptcha_challenge_field"]))
		{
			$resp = $this->recaptcha->checkAnswer(
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$this->getValue());
		
			if ($resp->isValid)
				return true;
			else
			{
				// We have an error code
				if (array_key_exists($resp->error, $this->errorMessages))
					$key = $resp->error;
				else 
					$key = "captcha-error";
			
				$this->errors[] = $this->errorMessages[$key];
			}
			
		}
		
		return false;
	}
	
	public function render()
	{
		echo $this->recaptcha->getHtml();
	}
}

?>