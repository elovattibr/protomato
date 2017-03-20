<?php

namespace Http;

class Route extends \ACL\Access  { 
    
    public $request = null, 
           $controller = null, 
           $method = null, 
           $parameters = [];

    public function __construct(Request $request) {

        if(!isset($request->session->app->settings['routes'])){
            throw new \Exception("Routes settings are not defined.", 500);
        }

        if(!isset($request->session->app->settings['routes']['public'])) {
            throw new \Exception("Default public route is not defined.", 500);
        }
        
        $this->request = $request;

        $this->set($request->uri);
    }

    public function trigger($response){

        if (!autoload($this->controller, "controllers")){
            throw new \Errors\PageNotFound($response, 404);
        }

        if(!method_exists($this->controller, $this->method)){
            throw new \Errors\PageNotFound($response, 405);
        }

        if(!$this->check()){
            throw new \Errors\AccessDenied($response, 403);
        }

        $instance = new $this->controller;

        $response->returns = $instance($response);

        return ob_get_clean();

    }    

    public function detect($args=[]) {

        $tree = [];

        while($tree[] = array_shift($args)){

            if(autoload($class = join("\\", $tree), 'controllers')){
                return [$class, array_shift($args), $args];
            }
        }

        return [$class, null, $args];
    }    

    public function set($URI="") {

        $sections = array_filter(explode('/',$URI), function($val){
            return (strlen(trim($val))>0)?true:false;
        });

        //No sections means empty URI
        if(!count($sections)){

            list($this->controller, $this->method) 
                    = $this->request->session->app->settings['routes']['public'];

            return;
        }

        //Single sections fix
        if(count($sections)===1) $sections[]='main';

        list($this->controller, $this->method, $this->parameters) 
                = $this->detect($sections);

    }   
    
}
