<?php

namespace Http;

class Response {
    
    public    $route;
    private   $dir;
    protected $output = [];

    public function __construct(Route $route) {

        $this->dir = getcwd();

        $this->route = $route;

        register_shutdown_function(array($this, '__exit'));
    }

    public function redirect($url){

        $previous = $this->output;

        $this->output = [
            'previous' => $previous,
            'redirect' => $url,
        ];

        $this->route->set($url);

        return $this->__toString();

    }

    public function setView($item){

       $path = realpath($this->dir .'/views/'.$item.'.tpl');

       if(!file_exists($path)){
          return false;
       }

       $this->__set('template', file_get_contents($path));

       return $item;
    }

    public function __set($key, $val){

        return $this->output[$key] = $val;
    }

    public function __get($key){
        
        return $this->output[$key];
    }

    public function __toString(){

        try {

            $buffer = $this->route->trigger($this);
            
        } catch (\Exception $e) {
         
            $this->message = $e->getMessage();
            $this->code    = $e->getCode()?:418;
            $this->trace   = $e->getTraceAsString();

            header("HTTP/1.0 500 {$this->code}");

            $this->setView('../public/templates/errors');
            
            return json_encode($this->output);
        }

        header('Content-Type: application/json');
        return json_encode(array_merge($this->output, [
            "buffer"  => $buffer
        ]));     
    }

    public function __exit($exception=false) {

        $error = error_get_last();

        if (($error !== null) && ($error['type'] === E_ERROR)) {

            $this->setView('../public/templates/errors');
            $this->code = 500;
            exit(json_encode(array_merge($this->output, $error)));
        }
    }    

}
