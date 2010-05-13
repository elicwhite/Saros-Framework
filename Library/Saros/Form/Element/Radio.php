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
class Library_Form_Element_Radio extends Library_Form_Element
{
	/*
		Validate the value of the element
	*/
	public function validate()
	{
		$valid = true;
		foreach ($this->validators as $validator)
		{
			// If it doesn't validate return false and break
			if (!$validator['validator']->isValid($this->getValue()))
			{
				$this->errors = array_merge($this->errors, $validator['validator']->getErrors());
				
				// return now if we are breaking on false
				if ($validator['breakOnFalse'])
					return false;
					
				$valid = false;
			}
		}

		return $valid;
	}
	
	public function render()
	{
		if ($this->getRequired())
		{
			$this->addAttribute("class", "required");
		}
		
		$attributes = "";
		foreach($this->getAttributes() as $key=>$value)
		{
			$attributes .= " ".$key.'= "'.$value.'"';
		}
		?>
		<input <?php echo $attributes?> type="text" name="<?php echo $this->getName()?>" value="<?php echo $this->getValue()?>" />
		<?php
	}
}

?>