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

    $dao = new BaseDao("savefavtestdb.users", DBConnection::getConnection());

    var_dump($dao->updateData(
        ["user_email" => "talin123@gmail.com", 
    "user_password" => "1234"],
        "WHERE user_email='bergnaum.aliyah@hermiston.com'"
    ));

    $router->addRoute("GET", "/", "HomeController@homepage");
    $router->addRoute("GET", "/login", "AuthenticationController@loginPage");
    $router->addRoute("GET", "/register", "AuthenticationController@registerPage");

    $router->handleRequest(get_request_method(), get_request_uri());
} catch (Exception $ex) {
    die($ex->getMessage());
}
