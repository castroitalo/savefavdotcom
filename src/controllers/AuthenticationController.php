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

        if (is_string($logged)) {
            create_session_data(CONF_SESSION_LOGIN_ERROR_KEY, $logged);

            redirectTo(get_url("/login-page?login=failed"));
        } else {
            if (validate_csrf_token($csrfToken)) {
                create_session_data(CONF_SESSION_LOGGED, true);
                create_session_data(CONF_SESSION_USER, $logged);
                delete_session_key(CONF_SESSION_CSRF_TOKEN);
                redirectTo(get_url("/"));
            } else {
                create_session_data(
                    CONF_SESSION_LOGIN_ERROR_KEY, 
                    "Failed to login. Try again later"
                );
                redirectTo(get_url("/login-page?login=failed"));
            }
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
        // Create view data
        $viewData = $this->createViewData(
            "/register.view.php",
            "Register",
            "/register.view.css",
            ""
        );

        View::renderView($viewData);
    }

    public function registerUser(array $params): void 
    {
        $inputEmail = $_POST["register_email"];
        $inputPassword = $_POST["register_password"];
        $csrfToken = $_POST["csrf_token"];
        $registered = (new UserModel())->registerUser($inputEmail, $inputPassword);

        if (is_string($registered)) {
            create_session_data(CONF_SESSION_REGISTER_ERROR_KEY, $registered);

            redirectTo(get_url("/register-page?register=failed"));
        } else {
            if (validate_csrf_token($csrfToken)) {
                create_session_data(CONF_SESSION_LOGGED, true);
                create_session_data(CONF_SESSION_USER, $registered);
                delete_session_key(CONF_SESSION_CSRF_TOKEN);
                redirectTo(get_url("/"));
            } else {
                create_session_data(
                    CONF_SESSION_REGISTER_ERROR_KEY, 
                    "Failed to register. Try again later"
                );
                redirectTo(get_url("/register-page?register=failed"));
            }
        }
    }
}
