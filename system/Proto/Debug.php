<?php

namespace Proto;

trait Debug {

    public function __invoke($response) {
		error_log("OI INVOKE");
        // ...

        parent::__invoke($response);
    }	
	
    public function __call($method, $args) {
		error_log("OI CALL");
        // ...

        parent::__call($response);
    }	
	

	function __debug(){

		error_log(var_export(func_get_args()));
	
	}
}