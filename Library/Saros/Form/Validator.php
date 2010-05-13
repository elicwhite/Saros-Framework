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
 * This is the parent class for all Validators
 */
abstract class Library_Form_Validator
{
	protected $errorMessages = array();
	
	protected $errorHolders = array();
	
	protected $errors = array();
	
	protected function setError($key)
	{
		$string = $this->errorMessages[$key];
		foreach($this->errorHolders as $holder => $value)
		{
			echo "Var: ".$this->$value;
			$string = str_replace("{::".$holder."::}", $this->$value, $string);
		}
		
		$this->errors[] = $string;
	}
	
	public function getErrors()
	{
		return $this->errors;
	}
}

?>