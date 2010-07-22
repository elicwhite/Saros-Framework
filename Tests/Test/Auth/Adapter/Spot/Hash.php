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

	public function setUp()
    {
    	$dbHost = "localhost";
		$dbName = "test";
		$dbUser = "root";
		$dbPass = "";

		$dbAdapter = new Spot_Adapter_Mysql($dbHost, $dbName, $dbUser, $dbPass);

		$mapper = new Fixture_Auth_Mapper($dbAdapter);

		$mapper->migrate();
		$mapper->truncateDatasource();

		$auth = Saros_Auth::getInstance();
		$authAdapter = new Saros_Auth_Adapter_Spot_Hash($mapper, "username", "password", "salt");

		$auth->setAdapter($authAdapter);

    	$this->sharedFixture = array("Mapper" => $mapper, "Auth" => $auth);
    }

	public function testUserCanLogIn()
	{
		$test = $this->sharedFixture["Mapper"];

		$user = $test->get();
		$user->username = "Eli";
		$user->salt = "3aca";
		$user->password = sha1($user->salt."whee");
		$test->save($user);

		$auth = $this->sharedFixture["Auth"];

		$auth->getAdapter()->setCredential("Eli", "whee");

		$auth->authenticate();

		$this->assertTrue($auth->hasIdentity());
	}

	// Find a way to make this and the test before it share code
	public function testInvalidUserCantLogIn()
	{
		$test = $this->sharedFixture["Mapper"];

		$user = $test->get();
		$user->username = "Eli";
		$user->salt = "3aca";
		$user->password = sha1($user->salt."true");
		$test->save($user);

		$auth = $this->sharedFixture["Auth"];

		$auth->getAdapter()->setCredential("Eli", "false");

		$auth->authenticate();

		$this->assertFalse($auth->hasIdentity());
	}

}


