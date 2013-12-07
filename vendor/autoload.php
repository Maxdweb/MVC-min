<?php

	function __autoload($classname) {
		foreach(Core::getClassRepositories() as $elt) {
			$filename = $elt.$classname.'.php';
 			
			if(file_exists($filename)) {			
				include_once($filename);
				return;
			}
		}
	}

?>
