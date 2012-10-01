<?php
/**
 *	ROUTING CONTROLLER
 *
 *	@description 	Controlls page requests and the associated pages.
 */

if(defined('DB_CONNECTED') && !DB_CONNECTED) {
	//---> Load Page Controller
	if(file_exists(ERROR_DB_CONTROLLER))
		include(ERROR_DB_CONTROLLER);

	//---> Load Page
	require(ERROR_DB_PAGE);
	exit();
}

//---> Define Requested Pages
define('REQ_PAGE_BASE',		(strlen(REQ) > 0 && strpos(REQ, DS) !== FALSE) ? substr(REQ, 0, strpos(REQ, DS)) : 'home');
define('REQ_PAGE_SUB',		(strlen(REQ) > 0 && strpos(substr(REQ, strpos(REQ, DS)), DS) !== FALSE) ? substr(REQ, strpos(REQ, DS)+1, -1) : FALSE);

//---> No Sub Page
if(!REQ_PAGE_SUB)
{
	$requested_page = REQ_PAGE_BASE.'.php';
} else {
	switch(REQ_PAGE_BASE) {
		default:
			//---> Build requested page path
			$requested_page = REQ_PAGE_BASE.'.php';
		break;
	}
}

define('REQUESTED_CONTROLLER',	CONTROLLERS . $requested_page);
define('REQUESTED_PAGE',		PAGES . $requested_page);

$debug['routes'] = print_r(REQ, TRUE).print_r(REQ_PAGE_BASE, TRUE).print_r(REQ_PAGE_SUB, TRUE).print_r(REQUESTED_PAGE, TRUE).print_r(REQUESTED_CONTROLLER, TRUE);

//---> Begin Output Buffering w/ GZIP Compression
if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

//---> Route To Page/Content
if(!file_exists(REQUESTED_PAGE))
{
	//---> Load Page Controller
	if(file_exists(ERROR_404_CONTROLLER))
		include(ERROR_404_CONTROLLER);

	//---> Load Page
	require(ERROR_404_PAGE);
} else { 
	//---> Define Initial Template Data
	$data['page'] = REQ_PAGE_BASE;
	$meta['title'] = ucwords(REQ_PAGE_BASE);

	//---> Load Page Controller
	if(file_exists(REQUESTED_CONTROLLER))
		include(REQUESTED_CONTROLLER);

	//---> Load Page
	if(!defined('IS_404') || !IS_404) {
		require(REQUESTED_PAGE);
	} else {
		//---> Load Page Controller
		if(file_exists(ERROR_404_CONTROLLER))
			include(ERROR_404_CONTROLLER);
	
		//---> Load Page
		require(ERROR_404_PAGE);
	}
}
