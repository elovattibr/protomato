<?php
return Array(
	
    /*App info*/
    'domain'       => 'protomato.local',
    'name'         => "Protomato",
    'title'        => "Protomato framework",
    'description'  => "Framework",
    'company'      => "Community",
    'version'      => "0.1",

    /*Local storage*/
    "storage" => "./data/",
    
    /*Default routes*/
    "routes" => [
        "cli" => ["server", "start"],
        "public" => ["home", "main"],
        "protected" => ["login", "main"],
    ],

    /*Dev server*/
	"server" => [
        /*Built in server info*/
        'address' => "0.0.0.0", //Means any IP
        'port' => "8080"
    ]
);