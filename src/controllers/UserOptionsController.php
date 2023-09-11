<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;
use src\models\UserModel;

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

    /**
     * Update user email
     *
     * @param array $params
     * @return void
     */
    public function updateEmail(array $params): void
    {
        $newUserEmail = $_POST["update_user_email"];
        $currentUserEmail = get_session_key_value(CONF_SESSION_KEY_USER)->user_email;
        $updatedUserEmail = (new UserModel())->updateUserDataEmail(
            $currentUserEmail,
            $newUserEmail
        );

        if (is_string($updatedUserEmail)) {
            create_session_data(
                CONF_SESSION_KEY_FAIL_TO_UPDATE_EMAIL,
                $updatedUserEmail
            );
            redirectTo(get_url("/user-options"));
        } else {
            create_session_data(
                CONF_SESSION_KEY_SUCCESS_TO_UPDATE_EMAIL,
                "Email updated successfully."
            );
            get_session_key_value(CONF_SESSION_KEY_USER)->user_email = $newUserEmail;
            redirectTo(get_url("/user-options"));
        }
    }

    /**
     * Update user password
     *
     * @param array $params
     * @return void
     */
    public function updatePassword(array $params): void 
    {
        $newUserPassword = $_POST["update_user_password"];
        $userEmail = get_session_key_value(CONF_SESSION_KEY_USER)->user_email;
        $updatedUserPassword = (new UserModel())->updateUserDataPassword(
            $userEmail,
            $newUserPassword
        );

        if (is_string($updatedUserPassword)) {
            create_session_data(
                CONF_SESSION_KEY_FAIL_TO_UPDATE_PASSWORD,
                $updatedUserPassword
            );
            redirectTo(get_url("/user-options"));
        } else {
            create_session_data(
                CONF_SESSION_KEY_SUCCESS_TO_UPDATE_PASSWORD,
                "Password updated successfully"
            );
            redirectTo(get_url("/user-options"));
        }
    }
}
