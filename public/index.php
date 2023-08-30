<?php

/**
 * Imports app's initial settings
 */
require __DIR__ . "/bootstrap.php";

use src\core\Router;
use src\core\Session;

try {
    $router = new Router();
    $session = new Session();
    
    /**
     * Web routes
     */
    $router->addRoute("GET", "/", "HomeController@homepage");
    $router->addRoute("GET", "/login-page", "AuthenticationController@loginPage");
    $router->addRoute("GET", "/register-page", "AuthenticationController@registerPage");
    $router->addRoute("POST", "/login-user", "AuthenticationController@loginUser");
    $router->addRoute("POST", "/register-user", "AuthenticationController@registerUser");

    // Execute web routes controller
    $router->handleRequest(get_request_method(), get_request_uri());
} catch (Exception $ex) {
    die($ex->getMessage());
}

