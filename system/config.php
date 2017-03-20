<?php

class config extends \Runtime\Controller{


	public function output ($request, $response){

		echo "\nACL CONFIG\n";

		$folders = $response->route->lists();

		$controllers = $folders['controllers'];

		$headers = ["Controller", "Method", "Type"];

		echo \tools::cliTable(array_reduce(array_keys($controllers), function($reduced, $controller) use ($controllers) {

			foreach ($controllers[$controller]['methods'] as $method => $definition) {

				$reduced[] = [$controller, $method, $definition['type']];
			}

			return $reduced;

		}, [$headers]));
	}
}
