<?php
/**
 *	MAIN SITE/APPLICATION CONTROLLER
 *
 *	@author 	Andrew Turner [Square One Agency]
 *	@version 	1.0
 */

//---> Include Bootstrap File (pulls in all required config files)
define('BASE_ROOT', __DIR__.DIRECTORY_SEPARATOR);
include_once(BASE_ROOT.'config/bootstrap.php');

//---> Debug Output
if(DBUG)
{
	echo '<br />---------------- DEBUG TEXT ----------------<br />'."\n";
	echo '<pre>'."\n";
	echo implode("\n<br /><br />\n", $debug);
	echo '</pre>';
}
