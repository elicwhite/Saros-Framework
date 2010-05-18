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
		require_once '../Library/Spot/tests/AllTests.php';
		
		
class Tests_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
		//PHPUnit_TextUI_Command::main();
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Saros Tests');

		
		
        $suite->addTestSuite(AllTests::suite());

        return $suite;
    }
}