<?php 

/**
 * 
 * This file contains all the app's route config constants
 * 
 */

define("CONF_ROUTES_URI_PATTERNS", [
    "(:alpha)" => "[a-z]+",
    "(:numeric)" => "[0-9]+",
    "(:alphanumeric)" => "[a-z0-9]+"
]);  // Dynamic route patterns
