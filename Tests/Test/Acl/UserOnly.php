<?php
/**
 * Tests only for user specific permissions
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Test_Acl_UserOnly extends PHPUnit_Framework_TestCase
{
	protected $backupGlobals = false;

	public function tearDown() {}

	public function setUp()
    {
    	$acl = new Saros_Acl(new Fixture_Acl_Adapter_UserPerms());
    	$identity = new Fixture_Acl_Identity();
		$acl->populate($identity->getIdentifier());

		$this->sharedFixture = array("Acl" => $acl);
    }

	public function testUserCantDeleteAdmin()
	{
		$value = $this->sharedFixture["Acl"]->can("Admin", "Delete");
		$this->assertFalse($value);
	}
	public function testUserCanViewAdmin()
	{
		$value = $this->sharedFixture["Acl"]->can("Admin", "View");
		$this->assertTrue($value);
	}
	public function testUserCantDeleteElse()
	{
		$value = $this->sharedFixture["Acl"]->can("Other", "Delete");
		$this->assertFalse($value);
	}
}


