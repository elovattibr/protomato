<?php

namespace ACL;

abstract class Control  {

    public function getId(){
        
        return $this->__get('user');

    }

    public function setId($data){


        return $this->__set('user', $data);
    }

    public function setPermission($group, $roles=[]){

        if(!($user = $this->getId())){
            return false;
        }       

        if(!isset($user['permissions'])){
            $user['permissions'] = [];
        }

        $user['permissions'][$group] = $roles;

        return $this->__set('user', $user);
    }

}