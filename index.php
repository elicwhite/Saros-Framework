<?php
/**
 * This class sets up the neccessary files and objects.
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */

// Lets turn on error reporting
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 'on');

define("ROOT_PATH",  realpath(dirname(__FILE__))."/");
     
require 'vendor/autoload.php';

\Saros\Application::run();