<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;

/**
 * Class UserOptionsController
 * 
 * @package src\controllers
 */
final class UserOptionsController
{
    use BaseController;

    /**
     * Render user options
     *
     * @param array $params
     * @return void
     */
    public function userOptions(array $params): void
    {
        $viewData = $this->createViewData(
            "/user_options.view.php",
            "User Options",
            "/user_options.view.css",
            ""
        );

        View::renderView($viewData);
    }

    public function updateData(array $params): void 
    {

    }

    public function deleteAccount(array $params): void 
    {

    }
}
