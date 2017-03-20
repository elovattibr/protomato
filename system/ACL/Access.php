<?php

namespace ACL;

abstract class Access extends Lists {

	public function check($controller=false, $method=false){

		$identification = $this->request->session->getId();

		$controller = $controller?:$this->controller;

		$method = $method?:$this->method;

		$definition = parent::get($controller);

		$methods = $definition['methods'];

		switch(true){

			case (COMMAND_LINE === true): return true;

			case ($definition === false): return false;

			case (!isset($methods[$method])): return false;

			case (!isset($methods[$method]['type'])): return false;

			case ($methods[$method]['type'] === 'public'): return true;

			case ($methods[$method]['type'] !== 'public' && !$identification): return false;

			case ($methods[$method]['type'] !== 'public' && !isset($identification['permissions'])): return false; 

			case (isset($identification['permissions'][$methods[$method]['group']])): return true; 
		}

		return false;
	}

}

