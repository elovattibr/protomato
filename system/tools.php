<?php

class tools {
    
    static function uuid(){
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0010
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }  
    
    //### CONSOLE ###
    static function console($array) {
        
        $message = "\n[".date('Y-m-d H:i:s',time())."]";
        
        foreach($array as $name => $value) {
            
            if($name === 0 || $name === false || $name === null) {
                $message .= " [{$value}]";
            } else {
                $message .= " [{$name}: '{$value}']";
            }
            
            
        }
        
        echo $message;
    }      

    static function cliTable($data) {
     
        // Find longest string in each column
        $columns = [];
        foreach ($data as $row_key => $row) {
            foreach ($row as $cell_key => $cell) {
                $length = strlen($cell);
                if (empty($columns[$cell_key]) || $columns[$cell_key] < $length) {
                    $columns[$cell_key] = $length;
                }
            }
        }
     
        // Output table, padding columns
        $table = '';
        foreach ($data as $row_key => $row) {
            foreach ($row as $cell_key => $cell)
                $table .= str_pad($cell, $columns[$cell_key]) . '   ';
            $table .= PHP_EOL;
        }
        return $table;
     
    }

    static function getArrayKeysBeginingWith($arr, $word){
    
        return array_reduce(array_keys($arr), function($result, $key) use ($arr, $word) {
            
            if(strpos($key, $word) !== false){
                if(strlen($arr[$key])){
                    $postfix = str_replace($word,"",$key);
                    $result[$postfix] = $arr[$key];
                }
            }
            
            return $result;
            
        },Array());
    }
    
    static function scanDirFilesByExtension($path, $extensions=array()){
        $files = Array();
        if(is_dir($path)){
            foreach(scandir($path) AS $name){
                switch(true){
                    case ($name == '.')  : break;
                    case ($name == '..') : break;
                    
                    default:
                    $file_path = $path . DIRECTORY_SEPARATOR . $name;
                    $file_info = pathinfo($file_path);
                    if(in_array($file_info['extension'], $extensions)){
                        $files[$file_info['filename']] = $file_path;
                    }
                }
            }
        }
        return $files;
    }
    
    static function getOsName(){

        return strstr(php_uname(), " ",true);    
    }

    static function checkPid($PID){
        
        switch (self::getOsName()){
            
            case 'Windows':
              exec("Tasklist /v /fi \"PID eq $PID\" /fo csv", $ProcessState);
              return(count($ProcessState) >= 2);
              
            case 'Linux':
                return (posix_getpgid($PID)!=false);
              
            
        }
    }
    
    static function realPath($path){

        return str_replace(Array("\\","/"), DIRECTORY_SEPARATOR,realpath($path));
    }
    
    static function usleep($msec) {

       $usec = $msec * 1000;
       @socket_select($read = NULL, $write = NULL, $sock = array(@socket_create (AF_INET, SOCK_RAW, 0)), 0, $usec);    
    }
    
    static function checkPhpCli() {

       return (php_sapi_name()=='cli')?true:false;
    }

    static function isJson($str){

        $parsed = json_decode($str, true);

        return (json_last_error()>0)?false:true;

    }
    
}