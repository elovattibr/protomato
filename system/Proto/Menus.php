<?php

namespace Proto;

trait Menus {
	
	function getMenus($groups=[]){

		$lists = $this->route->lists();

		$controllers = $lists['controllers'];

		$menus = [];

		foreach ($controllers as $controller => $config) {

			foreach ($config['methods'] as $method => $options) {
				
				if(isset($options['menu']) && $options['menu'] === 'false') {
					continue;
				}

				if(!$this->route->check($controller, $method)){
					continue;
				}

				if((count($groups) > 0) && !in_array($options['group'], $groups)) {
					continue;
				}
				
				$title = $options['title'] ?? false;

				$label = $options['label'] ?? false;

				$icon  = $options['icon'] ?? false;

				if(!$label && $title) {

					$menus[] = ['title' => $title, 'icon' => $icon, 'href' => "/{$controller}/{$method}"];

				} else if (!$title && $label) {

					$menus[] = ['label' => $label, 'href' => "/{$controller}/{$method}"];
				}


			}
		}

		return $menus;
	}

	
}