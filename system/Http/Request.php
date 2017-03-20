<?php

namespace Http;

class Request {

    private $data=[],
            $errors=[],
            $extract=[
                'post' => ['post'],
                'remote' => ['server','REMOTE_ADDR'],
                'method' => ['server','REQUEST_METHOD'],
                'agent' => ['server','HTTP_USER_AGENT'],
                'referer' => ['server','HTTP_REFERER'],
                'uri' => ['server','REQUEST_URI'],
            ];

    public $app, $session, $referal;

    public function __construct($session) {

        $this->session = $session;

        $this->referal = $this->getReferalInformation();

        $this->data = $this->getGlobals();

        $this->extractData();
    }

    public function export(){

        $keys = array_keys($this->extract);
        $data = $this;

        return array_reduce($keys, function($reduced, $key) use ($data) {

            if(isset($data->{$key})){
                $reduced[$key] = $data->{$key};
            }

            return $reduced;

        }, array_merge($this->referal, ['session' => &$this->session]));
    }

    private function extractData(){
        
        foreach($this->extract AS $key => $levels){

            $reference = &$this->{$key};

            $reference = $this->data;

            foreach ($levels as $level) {

                if(!isset($reference[$level])){
                    unset($reference);
                    break;
                }

                $reference = $reference[$level];
            }
        }
    }

    private function getGlobals(){

        $dataset = [];

        foreach($GLOBALS AS $key => $data){

            if($key==='GLOBALS') continue;

            $dataset[strtolower(ltrim($key, "_"))] = $data;
        }

        unset($GLOBALS);

        return $dataset;
    }    

    private function getReferalInformation() {

        $dataset = [];

        foreach (parse_url($_SERVER['HTTP_REFERER']) as $prop => $value) {

            switch ($prop) {

                case 'query': $prop="get"; parse_str($value, $value); break;
                case 'path': $prop="uri"; break;
            }

            $dataset[$prop] = $value;
        }

        return $dataset;
    }
    
}
