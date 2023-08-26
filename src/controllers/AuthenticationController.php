<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;

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
            "/login.view.js"
        );

        View::renderView($viewData);
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
