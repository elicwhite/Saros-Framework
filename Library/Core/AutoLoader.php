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
 * This class is responsible for helping to load all missing classes
 *
 */
class Library_Core_AutoLoader
{
	public static function class2File($classname)
	{
		$fileLocation = str_replace('_','/',$classname).".php";
		return $fileLocation;
	}
	
	// Autoload all of the classes that are not included
	public static function autoload($classname)
	{
		$fileLocation = self::class2File($classname);
		if (!file_exists($fileLocation))
			return false;
			
		require_once($fileLocation);
	
	}
}
?>