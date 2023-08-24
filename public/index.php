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
    $dummyData = generate_dummy_user_data();

    var_dump($userDao->createUser($dummyData["user_email"], $dummyData["user_password"]));

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
