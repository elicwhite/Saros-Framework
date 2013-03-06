<?php
namespace Saros;

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
class AutoLoader
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
        $fileLocation = str_replace("\\", "/", $classname).".php";
        return $fileLocation;
    }

    /**
    * Attempt to include the file that contains the class
    * specified by $classname.
    *
    * @param string $classname The name of the class to find.
    *
    */
    public static function autoload($className)
    {
        $loaded = false;
        //die($className);

        // Require Spot namespaced files by assumed folder structure (naming convention)
        if(false !== strpos($className, "Saros\\")) {
            $className = str_replace('Saros\\', '', $className);
            $classFile = trim(str_replace("\\", "/", str_replace("_", "/", $className)), '\\');
            $loaded = require_once(__DIR__ . "/" . $classFile . ".php");
        }

        return $loaded;
    }

    /**
    * Register the autoloader
    *
    */
    public static function register()
    {
        spl_autoload_register(array('\Saros\AutoLoader', 'autoload'));
    }
}