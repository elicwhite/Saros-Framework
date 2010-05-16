<?php
/**
 * This class helps create a list of script tags in layout headers
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 * 
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Saros_Display_Helpers_HeadScripts
{
	public $scripts = array();

	public function addScript($name)
	{
		$script = "Application/".$GLOBALS['registry']->router->getModule()."/Views/Scripts/".$name.".js";
		if (!file_exists(ROOT_PATH.$script))
			throw new Saros_Exception("Script ".$name." could not be found at ".$script);

		$this->scripts[] = $GLOBALS['registry']->config["siteUrl"].$script;

		return $this;
	}

	public function __toString()
	{
		$output = "";
		foreach ($this->scripts as $script)
		{
			$output .= '<script src="'.$script.'" type="text/javascript"></script>';
		}

		return $output;
	}
}
?>