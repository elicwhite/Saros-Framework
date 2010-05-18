<pre>
<?php
 
// Add PHPUnit to the include path
$incPath = get_include_path(); 
set_include_path("/mounted-storage/home45c/sub001/sc21473-GRUR" . PATH_SEPARATOR . $incPath); 

// Let execution time be infinite
set_time_limit(0);

// Require PHPUnit Files
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

/**
 * From Doctrine2's test suite code
 */
//if (!defined('PHPUnit_MAIN_METHOD')) {
//    define('PHPUnit_MAIN_METHOD', 'Tests_AllTests::main');
//}

//ini_set('include_path', ini_get('include_path').':/mounted-storage/home45c/sub001/sc21473-GRUR/:');

require_once('../Tests/AllTests.php');


//if (PHPUnit_MAIN_METHOD == 'Tests_AllTests::main') {
Tests_AllTests::main();
//}

?>
</pre>