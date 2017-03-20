<?php

class login extends \Runtime\Controller {

  	public /**
	* Login page 
    * @internal title 'Login'
    * @internal icon 'lock'
    * @internal group 'public'
    */ function main ($request, $response){

        $response->title = "Login";

        $response->user = $request->session->getId();

        $response->setView('login');
    }

    protected /**
    * Authentication controller
    * @internal group 'users'
    * @internal menu false
    */ function logout ($request, $response){

        $request->session->setId(false);
        
        return $response->redirect('/login');; 
    }

    public /**
    * Authentication controller
    */ function authenticate ($request, $response){

		$user = $request->post['username']?:null;
		$pass = $request->post['password']?:null;

        $response->title = "Login";

		//EMPTY FIELDS
        if(!strlen($user) || !strlen($pass)){
        	$response->message = "Usuário ou senha em branco";
	        $response->setView('login');
        	return;
        }

        $request->session->setId(['username' => $user]);
        $request->session->setPermission("users", ['add', 'update', 'remove', 'view']);

        //REDIRECT WHEN SUCCESSFUL
        return $response->redirect('/home');
    }

}
