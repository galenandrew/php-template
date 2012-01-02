<?php
/**
 *	ENVR Specific Globals
 *	
 *	@description	Sets environment globals (also used by WP Blog)
 */
switch(ENVR) {
	default: 
	case 'local':
		define('DB_HOST', 		'localhost');
		define('DB_NAME', 		'database');
		define('DB_USER', 		'username');
		define('DB_PASSWORD', 	'password');
	break;
	case 'development':
		define('DB_HOST', 		'localhost');
		define('DB_NAME', 		'database');
		define('DB_USER', 		'username');
		define('DB_PASSWORD', 	'password');
	break;
	case 'staging':
		define('DB_HOST', 		'localhost');
		define('DB_NAME', 		'database');
		define('DB_USER', 		'username');
		define('DB_PASSWORD', 	'password');
	break;
	case 'production':
		define('DB_HOST', 		'localhost');
		define('DB_NAME', 		'database');
		define('DB_USER', 		'username');
		define('DB_PASSWORD', 	'password');
	break;
}

//---> Connect to DB
$dbsvr = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
define('DB_CONNECTED', (!$dbsvr) ? FALSE : TRUE);
if(DB_CONNECTED) mysql_select_db(DB_NAME, $dbsvr);
