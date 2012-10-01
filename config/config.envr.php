<?php
/**
 *	Auto-Detect Environment
 *	
 *	@description	Auto-detects environment based on URL
 */
switch(BASE_URL) {
	case strpos(BASE_URL, '.local') !== FALSE:
		if(!defined('ENVR')) define('ENVR', 'local');
	break;
	case strpos(BASE_URL, 'dev.') !== FALSE:
		if(!defined('ENVR')) define('ENVR', 'development');
	break;
	case strpos(BASE_URL, 'staging.') !== FALSE:
		if(!defined('ENVR')) define('ENVR', 'staging');
	break;
	default: 
	case strpos(BASE_URL, 'www.') !== FALSE:
		if(!defined('ENVR')) define('ENVR', 'production');
		error_reporting(0); ini_set('display_errors', 0);
	break;
}
