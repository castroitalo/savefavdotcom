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

    if (str_contains($uri, "/savefavdotcom/public")) {
        return str_replace("/savefavdotcom/public", "", $uri);
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
 * @return void
 */
function get_url(string $path = "") 
{
    if (str_contains($_SERVER["HTTP_HOST"], "localhost")) {
        return CONF_URL_DEV . $path;
    }

    return CONF_URL_PROD . $path;
}
