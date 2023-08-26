<?php

declare(strict_types=1);

namespace src\core;

/**
 * Class Cookie
 * 
 * @package src\core
 */
final class Cookie
{
    /**
     * Set a new cookie
     *
     * @param string $cookieName
     * @param string $cookieValue
     * @return void
     */
    public static function createCookie(
        string $cookieName,
        string $cookieValue
    ): void {
        setcookie(
            $cookieName,
            $cookieValue,
            CONF_COOKIE_TIME,
            "/",
            "",
            true,
            true
        );
    }

    /**
     * Get cookie data as object
     *
     * @return object
     */
    public function getCookie(): object
    {
        return (object) $_COOKIE;
    }

    /**
     * Get a cookie value by it's key
     *
     * @param string $cookieKey
     * @return mixed
     */
    public static function getCookieValue(string $cookieKey): mixed
    {
        return $_COOKIE[$cookieKey] ?? "";
    }

    /**
     * Update a cookie value if it's set, if it's not create it
     *
     * @param string $cookieKey
     * @param mixed $cookieValue
     * @return void
     */
    public static function updateCookieValues(
        string $cookieKey,
        mixed $cookieValue
    ): void {
        $_COOKIE[$cookieKey] = $cookieValue;
    }

    /**
     * Delete cookie
     *
     * @param string $cookieKey
     * @return void
     */
    public static function deleteCookie(string $cookieKey): void 
    {
        setcookie($cookieKey, "", CONF_COOKIE_NEGATIVE_TIME, "/");
    }
}
