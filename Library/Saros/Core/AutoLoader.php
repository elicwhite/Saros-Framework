<?php
/**
 * This class is responsible for helping to load all missing classes
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Saros_Core_AutoLoader
{
	/**
	* Convert a class name to the expected file location
	* of that class
	*
	* @param string $classname The name of the class to convert
	*/
	public static function class2File($classname)
	{
        // Replace all of the underscores with slashes to find the path
        $fileLocation = str_replace("_","/", $classname).".php";
		return $fileLocation;
	}

	/**
	* Attempt to include the file that contains the class
	* specified by $classname. Attempts to support named libraries
	* that follow the Saros naming convention.
	*
	* @param string $classname The name of the class to find.
	*
	*/
	public static function autoload($classname)
	{
        $parts = explode("_",$classname);
		$fileLocation = self::class2File($classname);

        if (file_exists($fileLocation))
            require_once($fileLocation);
        // We want to check for named libraries
        // It is a named library when $parts[0] matches a folder in Library
        else if(is_dir("Library/".$parts[0]))
            require_once("Library/".$fileLocation);
        else
            // We don't know where this class exists. Maybe there is another autoloader that does
			return false;
	}
}