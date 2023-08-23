<?php

use src\core\DBConnection;
use src\core\Router;
use src\dao\BaseDao;
use src\dao\UserDao;

/**
 * Imports app's initial settings
 */
require __DIR__ . "/bootstrap.php";

try {
    $router = new Router();

    $userDao = new UserDao();

    var_dump($userDao->getUserById(3));

    /**
     * WEB ROUTES
     */
    $router->addRoute("GET", "/", "HomeController@homepage");
    $router->addRoute("GET", "/login", "AuthenticationController@loginPage");
    $router->addRoute("GET", "/register", "AuthenticationController@registerPage");

    $router->handleRequest(get_request_method(), get_request_uri());
} catch (Exception $ex) {
    die($ex->getMessage());
}
