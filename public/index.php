<?php

use src\core\DBConnection;
use src\core\Router;
use src\dao\BaseDao;

/**
 * Imports app's initial settings
 */
require __DIR__ . "/bootstrap.php";

try {
    $router = new Router();

    $dao = new BaseDao("savefavdotcom.users", DBConnection::getConnection());

    $new = $dao->createData([
        "user_email" => "fasdfhsajdasdfhklsadk@gmail.com",
        "user_password" => "1234567890"
    ]);

    var_dump($new);

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
