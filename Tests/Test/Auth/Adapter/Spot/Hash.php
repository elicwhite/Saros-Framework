<?php
/**
 * Tests for Saros_Core_Registry
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Test_Auth_Adapter_Spot_Hash extends PHPUnit_Framework_TestCase
{
	protected $backupGlobals = false;

	public function tearDown() {}


	public function testUserCanLogIn()
	{
		$dbHost = "localhost";
		$dbName = "test";
		$dbUser = "root";
		$dbPass = "";

		$dbAdapter = new Spot_Adapter_Mysql($dbHost, $dbName, $dbUser, $dbPass);

		$test = new Fixture_Auth_Mapper($dbAdapter);

		$test->migrate();
		$test->truncateDatasource();

		$user = $test->get();
		$user->username = "Eli";
		$user->salt = "3aca";
		$user->password = sha1($user->salt."whee");
		$test->save($user);

		$auth = Saros_Auth::getInstance();
		$authAdapter = new Saros_Auth_Adapter_Spot_Hash($test, "username", "password", "salt");

		$auth->setAdapter($authAdapter);

		$auth->getAdapter()->setCredential("Eli", "whee");

		$auth->authenticate();

		$this->assertTrue($auth->hasIdentity());
	}

}


