<?php 

/**
 * 
 * This file imports all config files inside the `config-files` folder
 * 
 */

// General config settings
define("CONF_ROOT_DIR", dirname(__DIR__, 1));  // App's root dir

require __DIR__ . "/config-files/config_namespace.php";
require __DIR__ . "/config-files/config_route.php";
