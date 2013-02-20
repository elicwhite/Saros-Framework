<?php
namespace Saros;

/**
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
class Application
{
    public static function run()
    {
        define("ROOT_PATH",  realpath(dirname(dirname(dirname(__FILE__))))."/");
        
        set_exception_handler(array('\Saros\Exception\Handler', 'handle'));
        
        /*
        Create an output buffer. This is being used
        so that we can at any point clear all output.
        For example; our exception handler
        does not display anything other than the exception
        message.
        */
        ob_start();

        // Create a new registry of variables
        $GLOBALS["registry"] = new \Saros\Core\Registry();
        
        // Load up the core set of utilities
        $GLOBALS["registry"]->utils = new \Saros\Core\Utilities();

        // Create a new registry object to be used for configuration
        $GLOBALS["registry"]->config  = new \Saros\Core\Registry();

        // Load the router
        $GLOBALS["registry"]->router = new \Saros\Core\Router();

        $GLOBALS["registry"]->display = \Saros\Display::getInstance($GLOBALS["registry"]);

        // Get the current route
        $GLOBALS["registry"]->router->parseRoute();

        // We want to setup our application
        \Application\Setup::doSetup($GLOBALS["registry"]);

        // Calls the module's setup file
        $GLOBALS["registry"]->router->setupModule();
               
        // Creates an instance of the class that will be
        // Called to generate our page
        $GLOBALS["registry"]->router->createInstance($GLOBALS["registry"]);

        /**
         * Sets the view. This can be changed
         * at any time before the class is run
         */
        $GLOBALS["registry"]->router->getInstance()->setView($GLOBALS["registry"]->display);
               
        // Run the controller
        $GLOBALS["registry"]->router->run();
                    
        // Display our page
        $GLOBALS["registry"]->display->parse();
    }
}
