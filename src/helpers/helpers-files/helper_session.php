<?php 

declare(strict_types=1);

use src\core\Session;

/**
 * Call Session::createSessionData
 *
 * @param string $session_key
 * @param mixed $session_value
 * @return void
 */
function create_session_data(string $session_key, mixed $session_value): void 
{
    (new Session())->createSessionData($session_key, $session_value);
}

/**
 * Call Session::getSessionKeyValue
 *
 * @param string $session_key
 * @return mixed
 */
function get_session_key_value(string $session_key): mixed 
{
    return (new Session())->getSessionKeyValue($session_key);
}

/**
 * Call Session::getSession
 *
 * @return object
 */
function get_session(): object 
{
    return (new Session())->getSession();
}

/**
 * Call Session::hasSessionKey
 *
 * @param string $session_key
 * @return boolean
 */
function has_session_key(string $session_key): bool
{
    return (new Session())->hasSessionKey($session_key);
}

/**
 * Call Session::updateSessionKey
 *
 * @param string $session_key
 * @param mixed $session_value
 * @return void
 */
function update_session_key(string $session_key, mixed $session_value): void 
{
    (new Session())->updateSessionKey($session_key, $session_value);
}

/**
 * Call Session::deleteSessionKey
 *
 * @param string $session_key
 * @return void
 */
function delete_session_key(string $session_key): void 
{
    (new Session())->deleteSessionKey($session_key);
}

/**
 * Call Session::deleteSession
 *
 * @return void
 */
function delete_session(): void 
{
    (new Session())->deleteSession();
}
