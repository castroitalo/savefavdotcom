<?php

declare(strict_types=1);

namespace src\controllers;

use src\core\View;
use src\dao\UserDao;
use src\models\UserModel;

/**
 * Class AccountActivationController
 * 
 * @package src\controllers
 */
final class AccountActivationController
{
    use BaseController;

    /**
     * Activate user email
     *
     * @param array $params
     * @return void
     */
    public function activateUser(array $params): void
    {
        $userEmail = $_GET["email"];
        $userToken = $_GET["token"];
        $activeUser = (new UserModel())->activateUserEmail($userEmail, $userToken);

        if (is_string($activeUser)) {
            create_session_data(
                CONF_SESSION_KEY_FAILED_ACTIVATE_ACCOUNT,
                $activeUser
            );
            redirectTo(get_url("/activate-page"));
        } else {
            create_session_data(CONF_SESSION_KEY_LOGGED, true);
            create_session_data(CONF_SESSION_KEY_USER, $activeUser);
            redirectTo(get_url("/"));
        }
    }

    /**
     * Render activation page for users that don't activate their email yet
     *
     * @param array $params
     * @return void
     */
    public function activatePage(array $params): void
    {
        // Create view data
        $viewData = $this->createViewData(
            "/activate_account.view.php",
            "Homepage",
            "",
            ""
        );

        View::renderView($viewData);
    }

    /**
     * Resend email for user
     *
     * @param array $params
     * @return void
     */
    public function resendActicationEmail(array $params): void
    {
        $userEmail = validate_email($_GET["email"]);
        $user = (new UserDao())->getUserByEmail($userEmail);
        $sent = (new UserDao())->sendActivationEmail(
            $userEmail,
            $user->user_activation_code
        );

        if ($sent) {
            create_session_data(CONF_SESSION_KEY_LOGGED, true);
            create_session_data(CONF_SESSION_KEY_USER, $user);
            create_session_data(
                CONF_SESSION_KEY_RESENT_ACTIVATION_EMAIL,
                "Email sent"
            );
            redirectTo(get_url("/"));
        } else {
            create_session_data(
                CONF_SESSION_KEY_FAIL_RESENT_ACTIVATION_EMAIL,
                "Failed to resent email confirmation. Try again later."
            );
            redirectTo(get_url("/"));
        }
    }
}
