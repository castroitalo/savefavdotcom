<?php

declare(strict_types=1);

namespace src\middlewares;

/**
 * Class AuthMiddleware
 * 
 * @package src\middleware
 */
final class AuthMiddleware
{
    /**
     * Check if user is logged in 
     *
     * @return void
     */
    public function isUserAuthenticated(): void 
    {
        if (!get_session_key_value(CONF_SESSION_LOGGED)) {
            redirectTo(get_url("/login-page"));
        }
    }
}
