<?php

define("ROOT_PATH",  realpath(dirname(dirname(__FILE__)))."/");
require ROOT_PATH.'vendor/autoload.php';
  
/**
* Autoload test fixtures
*/
function test_autoloader($className) {
    // Only autoload classes that start with "Test" and "Fixture"
    if(false === strpos($className, 'Test') && false === strpos($className, 'Fixture')) {
        return false;
    }
    
    $classFile = $className . '.php';
    $classFile = str_replace("\\", "/", $classFile);
    $file = __DIR__ . '/' . $classFile;
    
    if (file_exists($file)) {
        require_once $file;
    }                      
}
spl_autoload_register('test_autoloader');


// I don't like calling this here. I'm not quite sure how to solve this
//\Saros\Session::start();

?>