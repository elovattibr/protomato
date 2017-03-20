<?php

namespace Runtime;

class App {

    /*Singleton instance*/
    static $instance; 
    
    public $settings, $container;
    
    /*Private constructor. This class must be instantiated with Static init func*/
    private function __construct($configDir) {
        
        /*Built in settings file*/
        $this->settings = new \ArrayObject(autoconf($configDir), \ArrayObject::ARRAY_AS_PROPS);

        return $this->prepare();
    }
    
    /*Class initializer*/
    public static function setup($settings="config/") {
        
        if (!is_null(self::$instance) && is_a(self::$instance, __CLASS__))
            return self::$instance;

        return self::$instance = new self($settings);
    }   

    /*Late binding for newly instantiated classes*/
    public static function attach() {
        
        if (is_null(self::$instance))
            throw new \Exception("Can't attach a uninitialized application.");
        
        return self::$instance;
    }   

    /*Autoload plugins if exists*/
    private function prepare(){
        
        $autoload = &$this->settings->autoload;     
        
        if(isset($autoload)){
            
            foreach($autoload AS $key => $class){
                
                $settings = &$this->settings->{$key};
                
                if(isset($settings)){

                    $this->{$key} = new $class($settings);
                }
            }
        }
    }    
    
    public function run(){
        
        return (string) array_reduce(["Session", "Request","Route","Response"], function($prev, $cur) {
            
            $link = ENVIRONMENT."\\".$cur;

            return new $link( $prev );
            
        }, self::$instance);
    }

}

