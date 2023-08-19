<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\BaseController;
use src\core\View;

/**
 * Class HomeController
 * 
 * @package src\controllers
 */
final class HomeController extends BaseController
{
    /**
     * Render homepage 
     *
     * @param array $params
     * @return void
     */
    public function homepage(array $params): void
    {
        $viewData = $this->createViewData(
            "/homepage.view.php",
            "Homepage",
            "/homepage.view.css",
            ""
        );

        View::renderView($viewData);
    }
}
