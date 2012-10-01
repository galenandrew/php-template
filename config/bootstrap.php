<?php
include_once(BASE_ROOT.'config/config.php');
if(file_exists(PHP_SCRIPTS.'functions.php')) include_once(PHP_SCRIPTS.'functions.php');
if(defined('ROUTES') && ROUTES == TRUE) include_once(CONFIG_PATH.'routes.php');

//---> End Output Buffering
if(ob_get_length() !== FALSE) { ob_end_flush(); }
