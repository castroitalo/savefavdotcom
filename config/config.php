<?php 

/**
 * 
 * This file imports all config files inside the `config-files` folder
 * 
 */

// General config settings
define("CONF_ROOT_DIR", dirname(__DIR__, 1));  // App's root dir
define("CONF_ENV_TEST", dirname(__DIR__, 1) . "/tests/");  // Path to .env file for tests

// Import config files
require __DIR__ . "/config-files/config_namespace.php";
require __DIR__ . "/config-files/config_route.php";
require __DIR__ . "/config-files/config_url.php";
require __DIR__ . "/config-files/config_view.php";
require __DIR__ . "/config-files/config_password.php";
require __DIR__ . "/config-files/config_cookie.php";
require __DIR__ . "/config-files/config_session.php";
require __DIR__ . "/config-files/config_flash.php";
require __DIR__ . "/config-files/config_email_confirmatio.php";
require __DIR__ . "/config-files/config_mailer.php";

