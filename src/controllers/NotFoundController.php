<?php 

declare(strict_types=1);

namespace src\controllers;

use src\core\View;

final class NotFoundController
{
    use BaseController;

    /**
     * Render 404 page not found error page
     *
     * @param array $params
     * @return void
     */
    public function notFoundRoute(array $params): void 
    {
        $viewData = $this->createViewData(
            "/404.view.php",
            "Page Not Found",
            "/404.view.css",
            ""
        );

        View::renderView($viewData);
    }
}
