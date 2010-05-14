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
 * This class sets up the neccessary files and objects
 * 
 * test svn
 */

session_start();
// Lets turn on error reporting
error_reporting(E_ALL);
define("ROOT_PATH",  realpath(dirname(__FILE__))."/");



// Autoload all of the classes that are not included
require_once('Library/Saros/Core/AutoLoader.php');
spl_autoload_register(array('Saros_Core_AutoLoader', 'autoload'));

/*
function HandleException($exception)
{
	$registry->router->setController("Error");

}

set_exception_handler('HandleException'); */



// Create a new registry of variables
$registry = new Saros_Core_Registry();

// Load up the core set of utilities
$registry->utils = new Saros_Core_Utilities();

// Create a new configuration object
$registry->config  = new Saros_Config();

// Load the router
$registry->router = new Saros_Core_Router();

$registry->display = new Saros_Display($registry);
//try
//{
	$registry->display->init();
	
	// Get the current route
	$registry->router->parseRoute();
	
	// We want to setup our application
	Application_Setup::setup($registry);
	
	// Creates an instance of the class that will be
	// Called to generate our page
	$registry->router->createInstance($registry);
	
	/**
	 * Sets the view. This can be changed
	 * at any time before the class is run
	 */
	$registry->router->getInstance()->setView($registry->display);
	
	
	// Run the controller
	$registry->router->run();

//}
//catch(Exception $exception)
//{
///	echo $exception->getMessage();
//	die();
//}

// Display our page
$registry->display->parse();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">

<html>
<head>
  <meta name="generator" content=
  "HTML Tidy for Windows (vers 14 February 2006), see www.w3.org">

  <title></title>
</head>

<body>
</body>
</html>
