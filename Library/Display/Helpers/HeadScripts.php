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
 * This class helps create a list of script tags in layout headers
 */
class Library_Display_Helpers_HeadScripts
{
	public $scripts = array();
	
	public function addScript($name)
	{
		$script = "Application/".$GLOBALS['registry']->router->getModule()."/Views/Scripts/".$name.".js";
		if (!file_exists(ROOT_PATH.$script))
			throw new Library_Exception("Script ".$name." could not be found at ".$script);
			
		$this->scripts[] = $GLOBALS['registry']->config["siteUrl"].$script;
		
		return $this;
	}
	
	public function __toString()
	{
		$output = "";
		foreach ($this->scripts as $script)
		{
			$output .= '<script src="'.$script.'" type="text/javascript"></script>';
		}
		
		return $output;
	}
}
?>