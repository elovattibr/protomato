<?php

namespace Cli;

class Request {
    
    var $arguments, $session;
    
    public function __construct($session) {
        
        global $argv;

        $arguments = Array();
        
        foreach ($argv as $idx => $arg) {

        	if($idx>0){
            	$arguments[] = $arg;
        	}
        }

        $this->arguments = $arguments;

        $this->session = $session;
        
    }

    public function export(){

        return [
            'arguments' => $this->arguments,
        ];
    }    
    
}
