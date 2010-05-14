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
 * This class validates input that is only printable chars.
 */
class Saros_Form_Validator_Visible extends Saros_Form_Validator
{
	protected $errorMessages = array(
		"invalid" => "Your string must be only visible characters.",
	);
	
	public function isValid($value)
	{
		if (ctype_print($value))
			return true;
			
		$this->setError("invalid");
		return false;
	}
}
?>