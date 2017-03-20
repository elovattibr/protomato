<?php       

define('COMMAND_LINE', (php_sapi_name()=='cli')?true:false); //CLI AWARE
define('ROOT_FOLDER', dirname(__FILE__));  //ROOT FOlDER
define('ENVIRONMENT', (COMMAND_LINE===true)?"Cli":"Http");  //ROOT FOlDER
chdir(ROOT_FOLDER); //CHANGE SCRIPT WORKING DIR


//STD setup PSR autoloading
require 'system/std.php';
    
//Init and run just like zend 
print Runtime\App::setup()->run();     
       