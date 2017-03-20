<?php

namespace Cli;

class Route extends \ACL\Access {
    
    var $request,
        $module,
        $action,
        $extrap;
    
    function __construct(Request $request) {
        
        if(!isset($request->session->app->settings['routes'])){
            exit("Applications settings is empty.");
        }

        if(!isset($request->session->app->settings['routes']['cli'])) {
            exit("Default cli routes are not set.");
        }
        
        list($this->controller, $this->method) = $request->session->app->settings['routes']['cli'];

        $this->request = $request;

        $this->set($request->arguments);
        
    }

    public function output($response){

        if (!autoload($this->controller)){ //, "system"
            exit("\nSystem controller '{$this->controller}' was not found.");
        }

        if(!method_exists($this->controller, $this->method)){
            exit("\nSystem controller '{$this->controller}' do not has a method named '{$this->method}'.");
        }

        $instance = new $this->controller($this);

        return $instance($this->method, $this->request, $response);
    }    

  
    public function detect($args=[]) {

        $tree = [];

        while($tree[] = array_shift($args)){

            if(autoload($class = join("\\", $tree), 'system')){
                return [$class, array_shift($args), $args];
            }
        }

        return [implode($args,"//"), null, $args];
    }    

  
    public function set($args) {

        if(!count($args)){
            return;
        }

        list($this->controller, $this->method, $this->parameters) 
                = $this->detect($args);

    }    
    
}
