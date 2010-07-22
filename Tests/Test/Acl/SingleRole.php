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
class Test_Acl_SingleRole extends PHPUnit_Framework_TestCase
{
	protected $backupGlobals = false;

	public function tearDown() {}

	public function setUp()
    {
    	$acl = new Saros_Acl(new Fixture_Acl_Adapter_SingleRole());
    	$identity = new Fixture_Acl_Identity();
		$acl->populate($identity);

		$this->sharedFixture = array("Acl" => $acl);
    }

	public function testUserCanViewArticle1()
	{
		$value = $this->sharedFixture["Acl"]->can("Article1", "View");
		$this->assertTrue($value);
	}

	public function testUserCantEditArticle1()
	{
		$value = $this->sharedFixture["Acl"]->can("Article1", "Edit");
		$this->assertFalse($value);
	}
	public function testUserCantViewAdmin()
	{
		$value = $this->sharedFixture["Acl"]->can("Admin", "View");
		$this->assertFalse($value);
	}
	public function testUserCantDeleteElse()
	{
		$value = $this->sharedFixture["Acl"]->can("Other", "Delete");
		$this->assertFalse($value);
	}
}


