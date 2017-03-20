<?php

namespace Errors;

use Exception;

class PageNotFound extends Exception {
    
	private $route;

    public function __construct($response, $code = 404, Exception $previous = null) {
		
        $message = "Página não encontrada: '{$response->route->module}/{$response->route->action}'.";

        parent::__construct($message, $code, $previous);
    }

    // personaliza a apresentação do objeto como string
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }	
}