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
class Test_Acl_MultiRole extends PHPUnit_Framework_TestCase
{
	protected $backupGlobals = false;

	public function tearDown() {}

	public function setUp()
    {
    	$acl = new Saros_Acl(new Fixture_Acl_Adapter_MultiRole());
    	$identity = new Fixture_Acl_Identity();
		$perms = $acl->populate($identity->getIdentifier());

		$this->sharedFixture = array("Perms" => $perms);
    }

	public function testUserCanViewArticle1()
	{
		$value = $this->sharedFixture["Perms"]->can("Article1", "View");
		$this->assertTrue($value);
	}

	public function testUserCanEditArticle1()
	{
		$value = $this->sharedFixture["Perms"]->can("Article1", "Edit");
		$this->assertTrue($value);
	}
	public function testUserCanOwnSite()
	{
		$value = $this->sharedFixture["Perms"]->can("Site", "Own");
		$this->assertTrue($value);
	}
	public function testUserCantDeleteElse()
	{
		$value = $this->sharedFixture["Perms"]->can("Other", "Delete");
		$this->assertFalse($value);
	}
}


