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
 * This class makes sure a string is a url format
 */
class Library_Form_Validator_Url extends Library_Form_Validator
{
	protected $maxLength;

	protected $errorMessages = array(
		"invalid" => "Your URL is invalid.",
	);
	
	protected $errorHolders = array();
	
	
	public function isValid($value)
	{
		// Regex to match emails
		if(eregi("'|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i'", $value))
			return true;
			
		$this->setError("invalid");
		return false;
	}
}
?>

