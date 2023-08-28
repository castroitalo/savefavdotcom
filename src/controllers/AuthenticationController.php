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
        $logged = (new UserModel())->loginUser($inputEmail, $inputPassword);

        if (is_string($logged)) {
            create_session_data(CONF_SESSION_LOGIN_ERROR_KEY, $logged);

            redirectTo(get_url("/login-page?login=failed"));
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
        // $viewData = $this->createViewData(
        //     "/register.view.php",
        //     "Register",
        //     "/register.view.css",
        //     "/login.view.js"
        // );

        // View::renderView($viewData);

        var_dump("REGISTER PAGE");
    }
}
