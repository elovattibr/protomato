<?php

namespace Runtime; 

class  Controller {

	protected $route, $request, $session;
    
    public function __invoke($response){

    	$this->route = $response->route;

    	$this->request = $this->route->request;

    	$this->session = $this->request->session;

    	$method = $response->route->method;
    	
    	$request = $response->route->request;

        return $this->{$method}($request, $response);

    }

}

 