<?php

namespace Cli;

class Response {
    
    public    $app, $route;
    
    function __construct(Route $route) {
        
        if(!COMMAND_LINE){
            throw new \Errors\ModuleNotfound("Command line only.");
        }
        
        $this->app = \Runtime\App::attach();

        $this->route = $route;

    }

    function setView($item){

    }

    function __toString(){

        //Then let's instantiate the module that y've asked for
        $this->route->trigger($this);
        
        return (string) ob_get_clean();
    }    
    
}
