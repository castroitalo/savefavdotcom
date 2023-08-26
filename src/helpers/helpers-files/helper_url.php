<?php

declare(strict_types=1);

/**
 * Get requested URI
 *
 * @return string
 */
function get_request_uri(): string
{
    $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

    if (str_contains($uri, "/public")) {
        return str_replace("/public", "", $uri);
    }

    return $uri;
}

/**
 * Get request method
 *
 * @return string
 */
function get_request_method(): string 
{
    return $_SERVER["REQUEST_METHOD"];
}

/**
 * Get route URL for develompment/production environment
 *
 * @param string $path
 * @return string
 */
function get_url(string $path = ""): string
{
    if (str_contains($_SERVER["HTTP_HOST"], "localhost")) {
        return CONF_URL_DEV . $path;
    }

    return CONF_URL_PROD . $path;
}

/**
 * Redirect page to parameter path
 *
 * @param string $redirectTo
 * @return void
 */
function redirectTo(string $redirect_to_path): void 
{
    header("Location: " . $redirect_to_path);
    exit();
}
