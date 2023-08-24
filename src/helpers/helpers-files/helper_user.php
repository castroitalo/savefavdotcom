<?php

declare(strict_types=1);

/**
 * Validate input email
 *
 * @param string $email
 * @return string
 */
function validate_email(string $inputEmail): string
{
    return filter_var($inputEmail, FILTER_SANITIZE_EMAIL);
}

/**
 * Validate password 
 *
 * @param string $inputPassword
 * @return void
 */
function validate_password(string $inputPassword): bool
{
    if (
        mb_strlen($inputPassword) < CONF_PASSWORD_MIN_LEN ||
        mb_strlen($inputPassword) > CONF_PASSWORD_MAX_LEN
    ) {
        return false;
    }

    return true;
}

/**
 * Encrypt user password 
 *
 * @param string $inputPassword
 * @return void
 */
function encrypt_password(string $inputPassword)
{
    return password_hash($inputPassword, CONF_PASSWORD_ENC_ALGO);
}
