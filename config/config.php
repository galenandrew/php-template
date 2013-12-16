<?php
date_default_timezone_set('America/Chicago');
error_reporting(E_ALL); ini_set('display_errors', 1);

/**
 *	Global Variables
 *	
 *	@description	Define site-wide global variables
 */
//---> Paths
define('DS',                    DIRECTORY_SEPARATOR);
define('CONFIG_PATH',           BASE_ROOT . 'config' . DS);
define('TEMPLATE_PATH',         BASE_ROOT . 'templates' . DS);
define('MODULES_PATH',          TEMPLATE_PATH . 'modules' . DS);
define('CLASSES',               BASE_ROOT . 'classes' . DS);
define('CONTROLLERS',           BASE_ROOT . 'controllers' . DS);
define('PAGES',                 BASE_ROOT . 'pages' . DS);
define('PHP_SCRIPTS',           BASE_ROOT . 'scripts' . DS . 'php' . DS);
define('VIEWS',                 BASE_ROOT . 'views' . DS);
//---> Files
define('ERROR_404_CONTROLLER',  CONTROLLERS . 'error_404.php');
define('ERROR_404_PAGE',        PAGES . 'error_404.php');
define('ERROR_DB_CONTROLLER',   CONTROLLERS . 'error_db.php');
define('ERROR_DB_PAGE',         PAGES . 'error_db.php');
//---> Other
define('DBUG',                  FALSE);
define('SITE_HOST',             $_SERVER['HTTP_HOST']);
define('BASE_URL',              'http://' . $_SERVER['HTTP_HOST']);
define('REQ',                   isset($_GET['req']) ? $_GET['req']:'');
define('REQ_URI',               isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI']:'/');
define('ASYNC',                 isset($_GET['async_req']) ? TRUE : FALSE);
define('ROUTES',                !isset($_GET['no_routes']) || !$_GET['no_routes'] ? TRUE : FALSE);

/**
 *	Autoload Classes
 *	
 *	@description	Autoloads classes when initiated (use of __autoload is discouraged by PHP.net)
 */
spl_autoload_register(function($class_name) {
	if(strpos($class_name,'Controller') > -1) {
		$class_file = CONTROLLERS . $class_name . '.php';
		if(file_exists($class_file)) {
			require_once($class_file);
		}
	} else { 
		$class_file = CLASSES . strtolower($class_name) . '.class.php';
		if(file_exists($class_file)) {
			require_once($class_file);
		}
	}
});

//---> Include ENVR scripts
if(file_exists(CONFIG_PATH . 'config.envr.php')) include_once(CONFIG_PATH . 'config.envr.php');

include_once(CONFIG_PATH . 'db.php');