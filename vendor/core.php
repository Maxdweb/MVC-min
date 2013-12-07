<?php
	define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
	define('DIR_ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
	// GENERIC REPOSITORIES
	define('DIR_ASSETS', DIR_ROOT.'assets/');
	define('DIR_CTR', DIR_ROOT.'controlers/');
	define('DIR_VIEWS', DIR_ROOT.'views/');
	define('DIR_VENDOR', DIR_ROOT.'vendor/');	
	// VENDOR REPOSITORIES	
	define('BDD_DIR',DIR_VENDOR.'bdd/');
	// ASSETS REPOSITORIES
	define('CSS_DIR',DIR_ASSETS.'css/');
	define('IMG_DIR',DIR_ASSETS.'img/');

	class Core {
	// CLASS ATTRIBUTES
		private static $_appname = 'NEW MVC';
		private static $_classRepositories = array(DIR_VENDOR, BDD_DIR);
		private static $_activeCss = array();

	/* GETTERS */
		public static function getAppName() { return self::$_appname;}
		public static function getClassRepositories() { return self::$_classRepositories; }
		public static function getActiveCss() { return self::$_activeCss; }

	/* SETTERS */
		public static function setActiveCss($cssArray) {			
			if(is_array($cssArray)) {				
				foreach($cssArray as $elt)					
					self::$_activeCss[count(self::$_activeCss)] = $elt; 		
			}			
		}

	/* STATIC METHODS */
		public static function init() {
			self::emptyCss();

			// redirect to appropriate controler
			$controler = ($_REQUEST["page"] == "") ? "home" : $_REQUEST["page"];			
			if(file_exists(DIR_CTR.$controler.'.php'))
				include_once DIR_CTR.$controler.'.php';
			else {
				Core::setActiveCss(array('general'));
				Core::displayHeader();
				Core::displayViews(array('404'));
				Core::displayFooter();
			}
		}
		
	/* _activeCss STATIC METHOD */
		public static function emptyCss() { 
			self::$_activeCss = array(); 
		}

	/* DISPLAY STATIC METHODS */
		public static function displayHeader() {
			// include start of skeleton			
			include_once DIR_VIEWS.'sk_top.php';
			include_once DIR_VIEWS.'header.php';
		}

		public static function displayFooter() {
			// include end of skeleton
			include_once DIR_VIEWS.'footer.php';
			include_once DIR_VIEWS.'sk_bottom.php';
		}

		public static function displayViews($viewsArray) {
			if(is_array($viewsArray)) {
				foreach($viewsArray as $elt)
					include_once DIR_VIEWS.$elt.'.php';
			}
		}

		public static function displayCssLinks() {
			foreach(self::$_activeCss as $elt)
				echo '<link rel="stylesheet" type="text/css" href="assets/css/'.$elt.'.css">
		';
		}
	}

	include_once 'autoload.php';

?>
