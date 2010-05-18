<?php
/**
 * All tests to be run
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */

// Add the Spot testSuite
require_once '../Library/Spot/tests/init.php';
require_once '../Library/Spot/tests/Spot_Tests.php';


class Saros_Suite
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
		//PHPUnit_TextUI_Command::main();
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Saros Suite');


		// Add the Spot TestSuite
        $suite->addTestSuite(Spot_Tests::suite());

        return $suite;
    }
}