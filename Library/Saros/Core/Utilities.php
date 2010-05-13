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
 * This class contains miscellaneous utilities
 */
class Library_Core_Utilities
{
	/**
	 * Make a valid link to a controller. Ex:
	 * makeLink("index","view","4","bottom");
	 * to possibly jump to the bottom of page 4 in the index
	 *
	 * @param string $controller Logic Controller
	 * @param mixed	$arguments Set of arguments to use to make the links
	 */
	function makeLink($arguments)
	{
		$args = func_get_args();
		
		$middle="";
		
		// If we are not using UrlRewriting
		if (isset($GLOBALS['registry']->config["rewriting"]) &&
			!$GLOBALS['registry']->config["rewriting"])
			$middle = "?act=";		
		
		return $GLOBALS['registry']->config["siteUrl"].$middle.implode("/", $args);
	}
}


?>