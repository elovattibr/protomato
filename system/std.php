<?php 
ob_start() or die('Output buffer is required.');
session_start() or die('PHP Sessions are required.');

#UNCOMMENT IF NGINX/APACHE NOT SETUP PROPERLY
if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET'){
    include('index.html');
    exit;
}

if (isset($_SERVER['REQUEST_URI']) && preg_match('/\.(?:png|jpg|jpeg|gif|css|js|map|json|min)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}

function autoload($className, $dir=false) {
    
    $class = ltrim($className, '\\');
    
    $fileName  = '';
    
    $namespace = '';
    
    if (($lastNsPos = strrpos($class, '\\'))) {
        $namespace = substr($class, 0, $lastNsPos);
        $class = substr($class, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    
    $fileName .=  str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
    
    if(!$dir){
        foreach(["system", "controllers", "models", "libraries", "plugins"] AS $folder){
            if(autocheck($folder, $fileName)){
                return true;
            }
        }
    }
    
    return (autocheck($dir, $fileName));
    
}

function autocheck($dir, $file, $parent=true) {
    
    $root = ($parent)?realpath(".".DIRECTORY_SEPARATOR):".".DIRECTORY_SEPARATOR;
    $base = $root . DIRECTORY_SEPARATOR . $dir;
    $path = $base . DIRECTORY_SEPARATOR . $file;
    
    if(file_exists($path)) {
        require_once $path;
        return true;
    }
    
    return false;
    
}

function autoconf($path){
    
    $settings = Array();
    
    if(is_dir($path)){
        
        foreach(scandir($path) AS $name){
            
            if(in_array($name, ['.','..'])){
                continue;
            }
            
            $location = realpath($path . DIRECTORY_SEPARATOR . $name);
            
            switch(pathinfo($location)['extension']){
                case 'php'; $settings = array_merge_recursive($settings,require($location)); break;
                //case 'json'; $settings[$file] = json_decode(file_get_contents($location),true); break;
                //case 'ini'; $settings[$file] = parse_ini_file($location); break;
            }
            
        }
    }
    
    return $settings;
    
}

function exception($exception){

    switch((COMMAND_LINE===true)?"Cli":"Http"){

        case 'Cli':
            echo "Runtime error => '{$exception->getMessage()}'\n";
            echo $exception->getTraceAsString();
            exit();

        case 'Http':    
            echo "<h1>Runtime error</h1>";
            echo "<p>{$exception->getMessage()}</p>";
            echo "<pre>".$exception->getTraceAsString()."</pre>";
            echo "<pre>".var_export($exception,true)."</pre>";
            exit();
    };
}

spl_autoload_register('autoload');

set_exception_handler('exception');        

