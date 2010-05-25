<?php

/**
 * Our Test Runner
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */

error_reporting(E_ALL);

// Require PHPUnit Files
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

define("ROOT_PATH",  "../".realpath(dirname(__FILE__))."/");

echo ROOT_PATH."\n";
function userAutoload($classname)
{
    $parts = explode("_",$classname);
	$fileLocation = implode('/'.$parts).".php";

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
spl_autoload_register('userAutoload');


/**
 * From Doctrine2's test suite code
 */
//if (!defined('PHPUnit_MAIN_METHOD')) {
//    define('PHPUnit_MAIN_METHOD', 'Tests_AllTests::main');
//}

//ini_set('include_path', ini_get('include_path').':/mounted-storage/home45c/sub001/sc21473-GRUR/:');

require_once('Saros_Suite.php');
//require_once('../Library/Spot/tests/AllTests.php');

//if (PHPUnit_MAIN_METHOD == 'Tests_AllTests::main') {
Saros_Suite::main();
//}

?>