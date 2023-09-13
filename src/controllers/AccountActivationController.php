<?php

declare(strict_types=1);

namespace src\controllers;

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
        $userEmail = validate_email($_GET["email"]);
        $userToken = $_GET["token"];
        $user = (new UserDao())->getUserByEmail($userEmail);

        // If user is not active
        if ($user->user_active === 0) {
            $activeUser = (new UserModel())->activateUserEmail($userEmail, $userToken);

            // If user activation failed
            if (is_string($activeUser)) {
                create_session_data(
                    CONF_SESSION_KEY_FAILED_ACTIVATE_ACCOUNT,
                    $activeUser
                );
                redirectTo(get_url("/activate-page"));

            // If user activation succed
            } else {
                create_session_data(CONF_SESSION_KEY_LOGGED, true);
                create_session_data(CONF_SESSION_KEY_USER, $activeUser);
                redirectTo(get_url("/"));
            }
        
        // If user is active
        } else {
            exit();
        }
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

        // If new activation email was sent successfully
        if ($sent) {
            create_session_data(CONF_SESSION_KEY_LOGGED, true);
            create_session_data(CONF_SESSION_KEY_USER, $user);
            create_session_data(
                CONF_SESSION_KEY_RESENT_ACTIVATION_EMAIL,
                "Email sent"
            );
            redirectTo(get_url("/"));
        
        // If new activation email fails to be sent
        } else {
            create_session_data(
                CONF_SESSION_KEY_FAIL_RESENT_ACTIVATION_EMAIL,
                "Failed to resent email confirmation. Try again later."
            );
            http_response_code(401);
            redirectTo(get_url("/"));
        }
    }
}
