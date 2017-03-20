<?php

/**
* @internal label 'Home'
*/

class home extends \Runtime\Controller {

    use \Proto\Menus;

    public /**
    * Function description
    * @internal label 'Home page'
    * @internal menu false
    */ function main ($request, $response){

        $response->setView('docs/main');

        $response->title = "Protomato";

    	$response->links = $this->getMenus();

    }
 
}
