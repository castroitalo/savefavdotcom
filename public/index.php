<?php

/**
 * Imports app's initial settings
 */
require __DIR__ . "/bootstrap.php";

use src\core\Router;
use src\core\Session;
use src\dao\UserDao;

try {
    $router = new Router();
    $session = new Session();

    /**
     * Web routes
     */
    // Main pages
    $router->addRoute("GET", "/", "HomeController@homepage");
    $router->addRoute("GET", "/login-page", "AuthenticationController@loginPage");
    $router->addRoute("GET", "/register-page", "AuthenticationController@registerPage");

    // User options
    $router->addRoute("GET", "/logout-user", "AuthenticationController@logoutUser");

    // Authentication
    $router->addRoute("POST", "/login-user", "AuthenticationController@loginUser");
    $router->addRoute("POST", "/register-user", "AuthenticationController@registerUser");
    $router->addRoute("POST", "/new-fav", "FavController@createNewFav");
    $router->addRoute("POST", "/delete-fav", "FavController@deleteFav");

    // Email activation
    $router->addRoute("GET", "/activate-user", "AccountActivationController@activateUser");
    $router->addRoute("GET", "/activate-page", "AccountActivationController@activatePage");
    $router->addRoute("GET", "/resend-activation-email", "AccountActivationController@resendActicationEmail");

    // Page not found
    $router->addRoute("GET", "/404", "NotFoundController@notFoundRoute");

    // Execute web routes controller
    $router->handleRequest(get_request_method(), get_request_uri());
} catch (Exception $ex) {
    die($ex->getMessage());
}
