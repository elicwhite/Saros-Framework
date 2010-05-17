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
class Saros_Display_Helpers_HeadScripts extends Saros_Display_Helpers_Abstract
{
	public $scripts = array();

	public function addScript($name)
	{
		$script = $this->display->getThemeLocation()."Scripts/".$name.".js";
		if (!file_exists(ROOT_PATH.$script))
			throw new Saros_Display_Exception("Script ".$name." could not be found at ".ROOT_PATH.$script);

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