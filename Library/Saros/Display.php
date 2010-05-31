<?php
/**
 * This class helps create the displays for each page
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 *
 * @todo Add support for parse() to return a string of content
 */
class Saros_Display extends Saros_Core_Registry
{
	protected $registry;

	// The theme we are currently loading views from
	protected $themeLocation;

	// The name of the layout we want to use. Not validated
	protected $layoutName = null;

	// pointer to our functions class.
	protected $functions = null;

	// Whether we should show the view for the current page we are on
	protected $showAction = true;

	protected $headStyles;
	protected $headScripts;


	/**
	 * Creates a template class from a template file
	 *
	 * @param String $templateFile	Path to a template file
	 */
	function __construct(Saros_Core_Registry $registry)
	{
		$this->registry = $registry;
	}

	public function init()
	{
		$this->headStyles = new Saros_Display_Helpers_HeadStyles($this);

		$this->headScripts = new Saros_Display_Helpers_HeadScripts($this);
	}

	/**
	* Set the theme to use
	*
	* @param string $themeName The name of the theme to use
	*/
	public function setTheme($themeName)
	{
		$this->themeLocation = "Application/Themes/".$themeName."/";
		if (!is_dir(ROOT_PATH.$this->themeLocation))
			throw new Saros_Display_Exception("Theme ".$themeName." not found at ".ROOT_PATH.$themeLocation);
	}

	/**
	* A simple getter for the theme location
	*
	* @return string The path to the current theme directory
	*/
	public function getThemeLocation()
	{
		return $this->themeLocation;
	}

	/**
	* The name of the layout to use. This location isn't validated
	* at the time this function is run since it depends on the theme.
	*
	* @param string $layoutName The name of the layout to use.
	*/
	public function setLayout($layoutName)
	{
		$this->layoutName = $layoutName;
	}

	public function parse($return = false)
	{
		// Include the view if we haven't turned off the view
		if ($this->getShowView())
		{
			$layoutLocation = ROOT_PATH.$this->themeLocation."Layouts/".$this->layoutName.".php";
			if (!file_exists($layoutLocation))
				throw new Saros_Display_Exception("Layout ".$this->layoutName." not found at ".$layoutLocation);

			require_once($layoutLocation);
		}
	}

	public function showView($var)
	{
		$this->showAction = $var;
	}

	public function getShowView()
	{
		return $this->showAction;
	}

	// Gives our views a content function
	public function content()
	{
		$module = $GLOBALS['registry']->router->getModule();
		$logic = $GLOBALS['registry']->router->getLogic();
		$action = $GLOBALS['registry']->router->getAction();

		$viewLocation = ROOT_PATH.$this->themeLocation."Logic/".$module."/".$logic."/".$action.".php";

		if(!file_exists($viewLocation))
			throw new Saros_Display_Exception("The view for module: '".$module."', Logic: '".$logic."', Action: '".$action."' does not exist at ".$viewLocation);

		require_once($viewLocation);
	}

	public function HeadStyles()
	{
		return $this->headStyles;
	}
	public function HeadScripts()
	{
		return $this->headScripts;
	}
}