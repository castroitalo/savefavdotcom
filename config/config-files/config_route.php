<?php 

/**
 * 
 * This file contains all the app's route config constants
 * 
 */

// Dynamic URI paramter pattern
define("CONF_ROUTES_URI_PATTERNS", [
    "(:alpha)" => "[a-z]+",
    "(:numeric)" => "[0-9]+",
    "(:alphanumeric)" => "[a-z0-9]+"
]);  