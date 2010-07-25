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
class Test_Acl_Permission_Set extends PHPUnit_Framework_TestCase
{
	protected $backupGlobals = false;

	protected $p = null;

	public function tearDown() {}

	public function setUp()
    {
    	$this->p = new Saros_Acl_Permission_Set();
    }

    // user can view site inherited
    public function testEmptyPermissionIsArray()
	{
		$this->assertSame(array(), $this->p->getPermissions());
	}
}