<?php

namespace Http;

class Session extends \ACL\Control {

	private $cache = null, 
	 		$ssid = null, 
			$file = null,
			$data = [];

	public $app;

	public function __construct(\Runtime\App $app){

        $this->app = $app;

		$this->ssid = session_id();

		if(!isset($app->settings['storage'])){
			throw new \Exception("App error: Storage path is not defined.");
		}

		if(!file_exists($app->settings['storage']) && !mkdir($app->settings['storage'])){
			throw new \Exception("App error: Cannot create data storage directory. Check storage path permissions");
		}

		if(!file_exists($this->cache = $app->settings['storage'].DIRECTORY_SEPARATOR.'sessions') && !mkdir($this->cache)){
			throw new \Exception("App error: Cannot create sessions directory. Check storage path permissions");
		}

		return $this->initialize();
	}

	private function initialize(){

		$this->cache = realpath($this->cache);

		$this->file = $this->cache . DIRECTORY_SEPARATOR . $this->ssid;

		if(file_exists($this->file)){

			$this->data = json_decode(file_get_contents($this->file), true);

			return $this->__set("check_timestamp", time());
		}

		return $this->__set("create_timestamp", time());
	}

	public function &__get($key) {

		return $this->data[$key];
	}

	public function __set($key, $data) {

		$this->data[$key] = $data;

		file_put_contents($this->file, json_encode($this->data));
		
		return $this->data[$key];		
	}


}