<?php 

// Imports composer autoload
require __DIR__ . "/../vendor/autoload.php";

var_dump(CONF_ROOT_DIR);

// Initialize phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(CONF_ROOT_DIR);

$dotenv->load();
