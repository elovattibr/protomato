<?php

namespace Errors;

use Exception;

class AccessDenied extends Exception {
    
	private $route;

    public function __construct($response, $code = 403, Exception $previous = null) {

		$message = "Acesso não autorizado a página: '{$response->route->request->uri}'.";

        parent::__construct($message, $code, $previous);

    }

    // personaliza a apresentação do objeto como string
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }	
}