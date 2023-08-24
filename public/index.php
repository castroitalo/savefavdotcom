<?php

use src\core\Router;

/**
 * Imports app's initial settings
 */
require __DIR__ . "/bootstrap.php";

try {
    $router = new Router();

    $router->addRoute("GET", "/", "HomeController@homepage");
    $router->addRoute("GET", "/login", "AuthenticationController@loginPage");
    $router->addRoute("GET", "/register", "AuthenticationController@registerPage");

    $router->handleRequest(get_request_method(), get_request_uri());
} catch (Exception $ex) {
    die($ex->getMessage());
}
