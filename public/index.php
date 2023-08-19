<?php

/**
 * Imports app's initial settings
 */

use src\core\Router;

require __DIR__ . "/bootstrap.php";

try {
    $router = new Router();

    $router->addRoute("GET", "/", "HomeController@homepage");

    $router->handleRequest(get_request_method(), get_request_uri());
} catch (Exception $ex) {
    die($ex->getMessage());
}
