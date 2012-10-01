<?php
/**
 *	ENVR Specific Globals
 *	
 *	@description	Sets environment globals (also used by WP Blog)
 */
switch(ENVR) {
	default: 
	case 'local':
		if(file_exists(CONFIG_PATH . 'db.local.php')) {
			include_once(CONFIG_PATH . 'db.local.php');
		} else {
			define('DB_HOST', 		'localhost');
			define('DB_NAME', 		'database');
			define('DB_USER', 		'username');
			define('DB_PASSWORD', 	'password');
		}
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
$db = new DB_Utility();
define('DB_CONNECTED', (!$db->connected) ? FALSE : TRUE);
// use $db->dbsvr or ($this->dbsvr in inherited classes) for connection
