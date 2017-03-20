<?php

namespace Proto;

trait DocBlocks {

	private $cache, $scandir;

	private static $method_types = [
		'static'=>\ReflectionMethod::IS_STATIC,
		'public'=>\ReflectionMethod::IS_PUBLIC,
		'private'=>\ReflectionMethod::IS_PRIVATE,
		'protected'=>\ReflectionMethod::IS_PROTECTED,
	 ];

	public static function get($name){

		if(!autoload($name, 'controllers')){
			return false;
		}

		return self::reflect($name); 
	}

	public static function parse($dir){

		$file_list = self::scan($dir);

		$controllers = [];

		$comments = [];

		foreach($file_list AS $name => $contents){

			if(!autoload($name)){
				continue;
			}

			$controllers[$name] = self::reflect($name); 

		}

		return $controllers;
	}

	private static function scan($dir, $prefix=""){

		$controllers = [];

		$dir = realpath($dir);

	    foreach(scandir($dir) AS $file){
	        
	        if(in_array($file, ['.','..', 'std.php'])){
	            continue;
	        }

	        if(is_dir($path = realpath($dir . DIRECTORY_SEPARATOR . $file))) {

	        	$controllers=array_merge($controllers, self::scan($path, $prefix."$file\\"));

	        	continue;
	        }

	        $name = $prefix.str_replace('.php','', $file);

	        $controllers[$name] = $path;
	    }
	        
	    return $controllers;
	}

	private static function reflect($class){

		$reflection = new \ReflectionClass($class);

		$comments = $reflection->getDocComment();

		$types = self::$method_types;
		
		$methods = array_reduce($types, function($reduced, $type) use ($class, $types, $reflection) {

			foreach($reflection->getMethods($type) AS $method){

				if((ltrim($class, "\\") !== $method->class) || (substr($method->name, 0, 2) == "__")){
					continue;
				}

				$scope = array_search($type, $types);
				
				$comments = $method->getDocComment();

				$reduced[$method->name] = array_merge(self::getDocBlock($comments), ['type' => $scope]);;	

			}

			return $reduced;

		}, []);

		return array_merge(self::getDocBlock($comments), ["methods" => $methods]);
	}

	private static function getDocBlock ($comments){

		$pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, '()_].*)#"; $matches = [];

		$converter = function($items) {

			return array_reduce($items, function($reduced, $item){

				if(preg_match("#(?:@)([a-zA-Z0-9]+)\s*([a-zA-Z0-9]+)\s*(.*)#", $item, $matches)){

					array_shift($matches);

					list($prop, $key, $val) = $matches;

					$val = preg_replace('/(^[\"\']|[\"\']$)/', '', trim($val));

					if($prop === 'internal'){
						$arr = [$key => $val];
					} else {
						$arr = [$prop => [$key => $val]];
					}

					$reduced = array_merge_recursive($reduced, $arr);
				};

				return $reduced;
				
			},[]);
		};

		if(!preg_match_all($pattern, $comments, $matches)){
			return [];
		}
		
		array_shift($matches);

		return array_reduce($matches, function($reduced, $items) use ($converter) {

			return array_merge($reduced, $converter($items));

		}, []);	
	}

}

