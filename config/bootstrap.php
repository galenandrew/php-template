<?php
include_once(BASE_ROOT.'config/config.php');
if(file_exists(PHP_SCRIPTS.'functions.php')) include_once(PHP_SCRIPTS.'functions.php');
if(defined('DB_REQUIRED') && DB_REQUIRED) include_once(CONFIG_PATH.'db.php');
include_once(CONFIG_PATH.'routes.php');
