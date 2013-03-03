<?php

/**
* Autoload test fixtures
*/
function test_autoloader($className) {
    // Only autoload classes that start with "Test_" and "Entity_"
    if(false === strpos($className, 'Test_')) {
        return false;
    }
    $classFile = str_replace('_', '/', $className) . '.php';
    require __DIR__ . '/' . $classFile;
}
spl_autoload_register('test_autoloader');


// I don't like calling this here. I'm not quite sure how to solve this
Saros\Session::start();

?>