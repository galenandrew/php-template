<?php
include_once(BASE_ROOT.'config/config.php');
if(file_exists(PHP_SCRIPTS.'functions.php')) include_once(PHP_SCRIPTS.'functions.php');

if(defined('DB_CONNECTED') && !DB_CONNECTED) {
	//---> Load Page Controller
	if(file_exists(ERROR_DB_CONTROLLER))
		include(ERROR_DB_CONTROLLER);

	//---> Load Page
	require(ERROR_DB_PAGE);
	exit();
}

define('REQ_PAGE_BASE',         (strlen(REQ) > 0 && strpos(REQ, '/') !== FALSE) ? substr(REQ, 0, strpos(REQ, '/')) : 'home');
define('REQUESTED_CONTROLLER',	CONTROLLERS . ucwords(REQ_PAGE_BASE) . 'Controller.php');
define('REQUESTED_PAGE',		PAGES . REQ_PAGE_BASE);

//---> Begin Output Buffering w/ GZIP Compression
if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

if(defined('ROUTES') && ROUTES == TRUE) {
	$masterController = new MasterController();
}

//---> End Output Buffering
//if(ob_get_length() !== FALSE) { ob_end_flush(); }