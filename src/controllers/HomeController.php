<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;
use src\models\FavModel;

/**
 * Class HomeController
 * 
 * @package src\controllers
 */
final class HomeController
{
    use BaseController;

    /**
     * Get user data to be displayed
     *
     * @param int $userId
     * @return array|string
     */
    public function getUserData(int $userId): array|string 
    {
        return (new FavModel())->getAllUserFav($userId);
    }

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
            "/homepage.js"
        );

        // Get user's data if he's logged
        if (get_session_key_value(CONF_SESSION_KEY_LOGGED)) {
            $userId = get_session_key_value(CONF_SESSION_KEY_USER)->user_id;
            $viewData["user_data"] = $this->getUserData($userId);
        }

        View::renderView($viewData);
    }
}
