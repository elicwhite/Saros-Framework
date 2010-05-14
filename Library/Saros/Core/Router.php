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
 * This class takes the url route and loads the applicable controller / action
 */
class Saros_Core_Router
{
	// URL path of the route
	private $path = array();
	
	private $route = array(
		"module"	=> "",
		"logic"	=> "",
		"action"	=> "",
		"params"	=> array()
		);
	
	private $instance;

	
	public function getRoute()
	{
		if (!empty($_GET['act']))
			$this->path = explode('/',$_GET['act']);
			
		return $this->path;
	}
	/**
	 * Gets the route information (Module, Controller, page, and parameters) from the URL
	 *
	 */
	public function parseRoute()
	{		
		/*** get the route from the url ***/
		$parts = $this->getRoute();
		
		// Not a module, load up the default module
		if (!isset(Application_Setup::$defaultModule))
			throw new Saros_Core_Exception("The default module has not been defined in the application setup file.");
			
		// set the default module
		$this->route["module"] = Application_Setup::$defaultModule;
		
		/**
		 * First part is either a module or controller
		 */
		if(isset($parts[0]))
		{
			/**
			 * We have a first part, it is either a module or controller
			 * 
			 * It is a module if we have a folder with that name inside the Application
			 * directory AND it has a Setup.php
			 * 
			 */
			
			// First check if it is a module
			$mod = ucfirst($parts[0]);
			$modPath = ROOT_PATH."Application/".$mod;
			if (is_dir($modPath))
			{
				/**
				 * We have that directory, does not necessarily mean
				 * it is a module. Have to check it for a setup file
				 */
				if(file_exists($modPath."/Setup.php"))
				{
					$this->route["module"] = $mod;
					/**
					 * We are taking this value as the module,
					 * remove it from the route array
					 */
					array_shift($parts);
				}
			}
		}
		// At this point we can rely that $this->route["module"] has been set correctly
				
		$class = "Application_".$this->getModule()."_Setup";
		//die($class);
		if (!property_exists($class, "defaultLogic"))
			throw new Saros_Core_Exception("The default logic file has not been defined in the module setup file.");
		
		$props = get_class_vars($class);

		// Set our logic to default module logic
		$this->route["logic"] = $props["defaultLogic"];

		// Check if we have another url path (logic)
		if (isset($parts[0]) )
		{
			/**
			 * We are taking this value as the module,
			 * remove it from the route array
			 */
			$logic = ucfirst(array_shift($parts));
			$logicPath = ROOT_PATH."Application/".$this->route["module"]."/Logic";
			if (is_dir($logicPath))
			{
				/**
				 * We have that directory, does not necessarily mean
				 * it is a logic controller. Have to check it for a logic directory
				 */
				if(file_exists($logicPath."/".$this->route["logic"].".php"))
				{
					$this->route["logic"] = $logic;
				}
			}
		}
		
		/**
		 * We now know for sure that module and logic is set correctly
		 * 
		 * All we have left to check is our action file
		 */
		if (!property_exists($class, "defaultAction"))
			throw new Saros_Core_Exception("The default action has not been defined in the module setup file.");
		
		// Set our logic to default module logic
		$this->route["action"] = $props["defaultAction"];

		// Check if we have another url path (logic)
		if (isset($parts[0]) )
		{
			// We don't uppercase this one, action names are camelCased
			$action = array_shift($parts);
			
			if (method_exists($this->getClassName(), $action))
			{
				$this->route["action"] = $action;
			}
		}
			
		/**
		 * Module, Logic, Action is now correct
		 * Split apart the rest of the parameters
		 */
		while(count($parts) > 0)
		{
			$param = array_shift($parts);
			if (strpos($param, "=") !== false)
			{
				$paramParts = explode("=",$param);
				$this->route["params"][$paramParts[0]] = $paramParts[1];
			}
			else 
			{
				$this->route["params"][] = $param;
			}
		}
	}
	
	private function getClassName()
	{
		return "Application_".ucfirst($this->getModule())."_Logic_".ucfirst($this->getLogic());
	}

	public function createInstance($registry)
	{
		// Make a new class		
		$className = $this->getClassName();
		$this->instance = new $className($registry);
		$this->instance->setParams($this->getParams());
	}
	
	/**
	* Load the actual logic file
	*/
	public function run()
	{
		// Set the display instance for the class
		//$controller->setDisplay(new Saros_Core_Display())

		/*** check if the action is callable ***/
		if (!is_callable(array($this->instance, $this->getAction())))
			$this->action = 'index';
			
		// Run the setup for the module
		$class = "Application_".$this->getModule()."_Setup";
		if(method_exists($class, "setup"))
		{
			$setup = new $class;
			$setup->setup($GLOBALS['registry']);
		}

		/*** run the action and pass the parameters***/
		call_user_func_array(array($this->instance, $this->getAction()), $this->getParams());
	}
	
	public function getInstance()
	{
		return $this->instance;
	}
	public function getModule()
	{
		return $this->route["module"];
	}
	public function getLogic()
	{
		return $this->route["logic"];
	}
	public function setLogic($controller)
	{
		$this->route["logic"] = $controller;
	}
	public function getAction()
	{
		return $this->route["action"];
	}
	public function setAction($action)
	{
		$this->route["action"] = $action;
	}
	public function getParams()
	{
		return $this->route["params"];
	}
}


?>