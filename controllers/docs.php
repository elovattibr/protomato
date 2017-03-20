<?php

/**
* @internal label 'Documentation'
*/

class docs extends \Runtime\Controller {

    protected /**
    * @internal label 'Documentation'
    * @internal group 'users'
    */ function main ($request, $response){

        $response->setView('docs/main');

        $response->title = "Documentation";

    }


  
}
