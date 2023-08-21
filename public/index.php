<?php

/**
 * Imports app's initial settings
 */

use src\core\Router;
use src\dao\BaseDao;

require __DIR__ . "/bootstrap.php";

try {
    $router = new Router();

    $dao = new BaseDao("savefavdotcom.users");
    $user_id = 0;
    $data = $dao->readBy("WHERE user_id=:user_id", "user_id={$user_id}", "user_id");

    var_dump($data);

    /**
     * Apps's route
     */
    $router->addRoute("GET", "/", "HomeController@homepage");
    $router->addRoute("GET", "/login", "AuthenticationController@loginPage");
    $router->addRoute("GET", "/register", "AuthenticationController@registerPage");

    $router->handleRequest(get_request_method(), get_request_uri());
} catch (Exception $ex) {
    die($ex->getMessage());
}
