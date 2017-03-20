<?php

class server extends \Runtime\Controller {

	private $root="./", 
			$addr="0.0.0.0", 
			$port="8080";

    public function start($request, $reponse) {
        
        $settings = &$this->app->settings->server;
        
        $this->addr = isset($settings['address'])?$settings['address']:$this->addr;
        
        $this->port = isset($settings['port'])?$settings['port']:$this->port;
        
        $this->root = $this->root;
        
        /*Announce*/  
        echo "Starting server in '{$this->root}'\n";
        
        $cmdl = "php -S {$this->addr}:{$this->port} "
                .  " -t {$this->root}";
                        
        /*Run*/  
        passthru($cmdl);
        
    }

}
