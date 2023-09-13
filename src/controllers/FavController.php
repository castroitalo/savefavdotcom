<?php

declare(strict_types=1);

namespace src\controllers;

use src\models\FavModel;

/**
 * Class FavController
 *
 * @package src\controllers;
 */
final class FavController
{
    use BaseController;

    /**
     * Create a new fav in database with data from new fav form
     *
     * @param array $params
     * @return void
     */
    public function createNewFav(array $params): void
    {
        $favUrl = $_POST["new_fav_url"];
        $csrfToken = $_POST["csrf_token"];
        $userId = get_session_key_value(CONF_SESSION_KEY_USER)->user_id;
        $newFav = (new FavModel())->createFav($favUrl, $userId);

        // If fails to create a new fav
        if (is_string($newFav)) {
            create_session_data(CONF_SESSION_KEY_FAILED_TO_ADD_FAV, $newFav);
            http_response_code(401);
            redirectTo(get_url("/?new-fav=failed"));
        } else {

            // If a new fav was successfully added
            if (validate_csrf_token($csrfToken)) {
                redirectTo(get_url("/"));

            // If failes to create a new fav for corrupt CSRF token
            } else {
                create_session_data(
                    CONF_SESSION_KEY_FAILED_TO_ADD_FAV,
                    "Failed to add favorite."
                );
                redirectTo(get_url("/"));
            }
        }
    }

    /**
     * Delete favorite
     *
     * @param array $params
     * @return void
     */
    public function deleteFav(array $params): void
    {
        $favId = intval($_POST["fav_id"]);
        $csrfToken = $_POST["csrf_token"];
        $deleted = (new FavModel())->deleteFav($favId);

        // If failes to delete fav
        if (is_string($deleted)) {
            create_session_data(
                CONF_SESSION_KEY_FAILED_TO_DELETE_FAV,
                $deleted
            );
            http_response_code(401);
            redirectTo(get_url("/"));
        } else {

            // If a fav was successfully deleted
            if (validate_csrf_token($csrfToken)) {
                redirectTo(get_url("/"));

            // If failes to delete fav for corrupt CSRF token
            } else {
                create_session_data(
                    CONF_SESSION_KEY_FAILED_TO_ADD_FAV,
                    "Failed to delete favorite."
                );
                redirectTo(get_url("/"));
            }
        }
    }
}
