<?php
/**
 * Copyright Eli White & SaroSoftware 2010
 * Last Modified: 3/26/2010
 * 
 * This file is part of Saros Framework.
 * 
 * Saros Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Saros Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Saros Framework.  If not, see <http://www.gnu.org/licenses/>.
 *
 * This class helps create the displays for each page
 */
class Saros_Display
{	
	private $registry;
	
	// location of the view file we are using
	private $viewLocation = null;

	// array that contains all the vars accessible by the template template
	private $variables = array();
	
	// pointer to our functions class.
	private $functions = null;
	
	// Whether we should show the view for the current page we are on
	private $showAction = true;
	
	private $headStyles;
	private $headScripts;
	
	
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
		$this->headStyles = new Saros_Display_Helpers_HeadStyles();
		
		$this->headScripts = new Saros_Display_Helpers_HeadScripts();
	}
	
	public function setLayout($layoutName)
	{
		$this->viewLocation = ROOT_PATH."Application/".$this->registry->router->getModule()."/Views/Layouts/".$layoutName.".php";
		if (!is_file($this->viewLocation))
		{
			throw new Saros_Exception("Layout ".$layoutName." not found at ".$this->viewLocation);
		}
	}
	
	public function __get($var)
	{
		//if (array_key_exists($var, $this->variables))
			return $this->variables[$var];
	}
	public function __set($var, $value)
	{
		$this->variables[$var] = $value;
	}
	
	public function parse($return = false)
	{
		// Include the view if we haven't turned off the view
		if ($this->getShowView())
			require_once($this->viewLocation);
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
		$viewLocation = ROOT_PATH.'Application/'.$module.'/Views/Logic/'.$logic.'/'.$action.'.php';
		
		if(!file_exists($viewLocation))
			throw new Exception("The view for module: '".$module."', Logic: '".$logic."', Action: '".$action."' does not exist at ".$viewLocation);
		
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
		
?>