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
 * This class makes sure a string is greater than a certain length
 */
class Saros_Form_Validator_MinLength extends Saros_Form_Validator
{
	protected $minLength;

	protected $errorMessages = array(
		"tooShort" => "Your string must be at least {::min::} characters",
	);
	
	protected $errorHolders = array(
		"min"	=> "minLength"
	);
	
	function __construct($options)
	{
		if (!isset($options[0]))
			throw new Exception("You must set a Min Length on the Validator");
			
		$this->minLength = $options[0];
	}
	
	public function isValid($value)
	{
		if (strlen($value) >= $this->minLength)
			return true;
			
		$this->setError("tooShort");
		return false;
	}
}
?>