<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;
use src\models\UserModel;

/**
 * Class AuthenticationController
 * 
 * @package src\controllers
 */
final class AuthenticationController
{
    use BaseController;

    /**
     * Render login page
     *
     * @param array $params
     * @return void
     */
    public function loginPage(array $params): void
    {
        // Create view data
        $viewData = $this->createViewData(
            "/login.view.php",
            "Login",
            "/login.view.css",
            "/authentication.js"
        );

        View::renderView($viewData);
    }

    /**
     * Login user into platform
     *
     * @param array $params
     * @return void
     */
    public function loginUser(array $params): void
    {
        $inputEmail = $_POST["login_email"];
        $inputPassword = $_POST["login_password"];
        $csrfToken = $_POST["csrf_token"];
        $logged = (new UserModel())->loginUser($inputEmail, $inputPassword);

        // If login failed for wrong authentication data
        if (is_string($logged)) {
            create_session_data(CONF_SESSION_KEY_LOGIN_ERROR, $logged);
            http_response_code(401);
            redirectTo(get_url("/login-page?login=failed"));

        // If authentication data is correct
        } else {

            // If login fails for corrupt CSRF token
            if (validate_csrf_token($csrfToken)) {
                create_session_data(CONF_SESSION_KEY_LOGGED, true);
                create_session_data(CONF_SESSION_KEY_USER, $logged);
                delete_session_key(CONF_SESSION_KEY_CSRF_TOKEN);
                redirectTo(get_url("/"));

            // If login was well succed
            } else {
                create_session_data(
                    CONF_SESSION_KEY_LOGIN_ERROR,
                    "Failed to login. Try again later"
                );
                http_response_code(401);
                redirectTo(get_url("/login-page?login=failed"));
            }
        }
    }

    /**
     * Logout user from platform 
     *
     * @param array $params
     * @return void
     */
    public function logoutUser(array $params): void
    {
        // If logout fails
        if (!get_session_key_value(CONF_SESSION_KEY_LOGGED)) {
            create_session_data(CONF_SESSION_KEY_LOGIN_ERROR, "Failed to logout.");
            http_response_code(401);
            redirectTo(get_url("/"));

        // If logout succed
        } else {
            delete_session();
            redirectTo(get_url("/"));
        }
    }

    /**
     * Render register page
     *
     * @param array $params
     * @return void
     */
    public function registerPage(array $params): void
    {
        $viewData = $this->createViewData(
            "/register.view.php",
            "Register",
            "/register.view.css",
            ""
        );

        View::renderView($viewData);
    }

    /**
     * Register new user to the platform
     *
     * @param array $params 
     * @return void 
     */
    public function registerUser(array $params): void
    {
        $inputEmail = $_POST["register_email"];
        $inputPassword = $_POST["register_password"];
        $csrfToken = $_POST["csrf_token"];
        $registered = (new UserModel())->registerUser($inputEmail, $inputPassword);

        // If registration fails for incorrect provided data
        if (is_string($registered)) {
            create_session_data(CONF_SESSION_KEY_REGISTER_ERROR, $registered);
            http_response_code(401);
            redirectTo(get_url("/register-page?register=failed"));

        // If registration data was correct
        } else {

            // If registration fails for corrupt CSRF token 
            if (validate_csrf_token($csrfToken)) {
                create_session_data(CONF_SESSION_KEY_LOGGED, true);
                create_session_data(CONF_SESSION_KEY_USER, $registered);
                delete_session_key(CONF_SESSION_KEY_CSRF_TOKEN);
                redirectTo(get_url("/"));

            // If registration succeed
            } else {
                create_session_data(
                    CONF_SESSION_KEY_REGISTER_ERROR,
                    "Failed to register. Try again later"
                );
                http_response_code(401);
                redirectTo(get_url("/register-page?register=failed"));
            }
        }
    }
}
