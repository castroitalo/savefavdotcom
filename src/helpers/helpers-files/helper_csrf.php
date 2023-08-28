<?php 

declare(strict_types=1);

/**
 * Create a CSRF token to session 
 *
 * @return void
 */
function create_csrf_token(): void 
{
    $csrf_token = bin2hex(openssl_random_pseudo_bytes(8));
    
    create_session_data(CONF_SESSION_CSRF_TOKEN, $csrf_token);
}

/**
 * Get CSRF token value 
 *
 * @param string 
 */
function get_csrf_token(): string 
{
    return get_session_key_value(CONF_SESSION_CSRF_TOKEN);
}

/**
 * Valida CSRF token from form with the CSRF token from session  
 *
 * @param string $input_csrf_token
 * @return bool
 */
function validate_csrf_token(string $input_csrf_token): bool 
{
    if (get_session_key_value(CONF_SESSION_CSRF_TOKEN) === $input_csrf_token) {
        return true;
    }

    return false;
}

