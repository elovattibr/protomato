<?php

namespace Cli;

class Session {

	private $cache = null, 
	 		$ssid = null, 
			$file = null,
			$data = [];

	public $app;

	public function __construct(\Runtime\App $app){

        $this->app = $app;

	}


}