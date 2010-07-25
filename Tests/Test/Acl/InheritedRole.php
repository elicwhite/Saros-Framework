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
class Test_Acl_InheritedRole extends PHPUnit_Framework_TestCase
{
	protected $backupGlobals = false;

	public function tearDown() {}

	public function setUp()
    {
    	$acl = new Saros_Acl(new Fixture_Acl_Adapter_InheritedRole());
    	$identity = new Fixture_Acl_Identity();
		$perms = $acl->populate($identity->getIdentifier());

		$this->sharedFixture = array("Perms" => $perms);
    }

    // user can view site inherited
    public function testUserCanViewSite()
	{
		//var_dump($this->sharedFixture["Perms"]->getPermissions());
		//die();
		$value = $this->sharedFixture["Perms"]->can("Site", "View");
		$this->assertTrue($value);
	}

	// inherited
	public function testUserCanViewArticle1()
	{
		$value = $this->sharedFixture["Perms"]->can("Article1", "View");
		$this->assertTrue($value);
	}

	// inherited
	public function testUserCanEditArticle1()
	{
		$value = $this->sharedFixture["Perms"]->can("Article1", "Edit");
		$this->assertTrue($value);
	}

	//  direct role
	public function testUserCanDeleteArticle1()
	{
		$value = $this->sharedFixture["Perms"]->can("Article1", "Delete");
		$this->assertTrue($value);
	}

	// overriden
	public function testUserCantViewAdmin()
	{
		$value = $this->sharedFixture["Perms"]->can("Admin", "View");
		$this->assertFalse($value);
	}

	public function testUserCantDeleteElse()
	{
		$value = $this->sharedFixture["Perms"]->can("Other", "Delete");
		$this->assertFalse($value);
	}
}