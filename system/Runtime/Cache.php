<?php

namespace Runtime;

class Cache {
    
    private $obj    = false, 
    		$id		= null,
    		$host   = '127.0.0.1',
    		$port   = '11211';

    function __construct($id="app"){ 

        $this->id = $id; 

        $this->obj = new \Memcached($id); 

        $this->online = $this->connect($this->host, $this->port);
    } 

    public function connect($host , $port){ 
    	
        $servers = $this->obj->getServerList(); 
        
        if(is_array($servers)) { 
                foreach ($servers as $server) 
                        if($server['host'] == $host and $server['port'] == $port) 
                                return true; 
        } 

        return $this->obj->addServer($host , $port); 
    } 

    public function __get($key){
    	
    	return $this->obj->get($key);
    }
    
    public function __set($key, $data){

		return $this->obj->set($key, $data);
    }

}


