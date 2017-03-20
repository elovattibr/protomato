<?php

namespace ACL;

abstract class Lists {

	use \Proto\DocBlocks;
	
	public function filter($items){
		return $items;
	}

	public function lists(){

		$folders = ['controllers','models','system'];
		$lists = [];
		
		foreach($folders AS $folder){

			$lists[$folder] = $this->parse("./{$folder}");
		}

		return $lists;
	}
}

