<?php
date_default_timezone_set('America/Chicago');
error_reporting(0); ini_set('display_errors', 0);

/**
 *	Global Variables
 *	
 *	@description	Define site-wide global variables
 */
//---> Paths
define('DS', 					DIRECTORY_SEPARATOR);
define('CONFIG_PATH',			BASE_ROOT . 'config' . DS);
define('TEMPLATE_PATH', 		BASE_ROOT . 'templates' . DS);
define('CLASSES', 				BASE_ROOT . 'classes' . DS);
define('CONTROLLERS', 			BASE_ROOT . 'controllers' . DS);
define('PAGES', 				BASE_ROOT . 'pages' . DS);
define('PHP_SCRIPTS', 			BASE_ROOT . 'scripts' . DS . 'php' . DS);
//---> Files
define('ERROR_404_CONTROLLER',	CONTROLLERS . 'error_404.php');
define('ERROR_404_PAGE',		PAGES . 'error_404.php');
define('ERROR_DB_CONTROLLER',	CONTROLLERS . 'error_db.php');
define('ERROR_DB_PAGE',			PAGES . 'error_db.php');
//---> Other
define('DB_REQUIRED', 			FALSE);
define('DBUG', 					FALSE);
define('BASE_URL',				$_SERVER['HTTP_HOST']);
define('REQ', 					isset($_GET['req']) ? $_GET['req']:'');
define('REQ_URI', 				isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI']:'/');
define('ASYNC', 				isset($_GET['async_req']) ? TRUE : FALSE);
define('ROUTES', 				!isset($_GET['no_routes']) || !$_GET['no_routes'] ? TRUE : FALSE);

/**
 *	Autoload Classes
 *	
 *	@description	Autoloads classes when initiated (use of __autoload is discouraged by PHP.net)
 */
spl_autoload_register(function($class_name) { 
	$class_file = CLASSES . strtolower($class_name) . '.class.php';
	if(file_exists($class_file)) { 
		require_once($class_file);
	} 
}); 

//---> Include ENVR scripts
if(file_exists(CONFIG_PATH . 'config.envr.php')) include_once(CONFIG_PATH . 'config.envr.php');

//---> Include DB scripts if needed
if(defined('DB_REQUIRED') && DB_REQUIRED) include_once(CONFIG_PATH . 'db.php');
