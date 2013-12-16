<?php
/**
 *	Auto-Detect Environment
 *	
 *	@description	Auto-detects environment based on URL
 */
switch(SITE_HOST) {
	case strpos(SITE_HOST, '.local') !== FALSE:
		if(!defined('ENVR')) define('ENVR', 'local');
	break;
	case strpos(SITE_HOST, 'dev.') !== FALSE:
		if(!defined('ENVR')) define('ENVR', 'development');
		error_reporting(0); ini_set('display_errors', 0);
	break;
	case strpos(SITE_HOST, 'staging.') !== FALSE:
		if(!defined('ENVR')) define('ENVR', 'staging');
		error_reporting(0); ini_set('display_errors', 0);
	break;
	default: 
	case strpos(SITE_HOST, 'www.') !== FALSE:
		if(!defined('ENVR')) define('ENVR', 'production');
		error_reporting(0); ini_set('display_errors', 0);
	break;
}
