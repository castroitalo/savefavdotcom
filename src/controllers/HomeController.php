<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;

/**
 * Class HomeController
 * 
 * @package src\controllers
 */
final class HomeController
{
    use BaseController;

    /**
     * Render homepage 
     *
     * @param array $params
     * @return void
     */
    public function homepage(array $params): void
    {
        // Create view data
        $viewData = $this->createViewData(
            "/homepage.view.php",
            "Homepage",
            "/homepage.view.css",
            ""
        );

        View::renderView($viewData);
    }
}
