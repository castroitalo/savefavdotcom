<?php 

declare(strict_types=1);

namespace src\core;

/**
 * Class Session
 * 
 * @package src\core
 */
final class Session 
{
    /**
     * Session constructor
     */
    public function __construct()
    {
        if (!session_id()) {
            session_start();
        }

        $_SESSION["logged"] = false;
    }

    /**
     * Create a new session key in $_SESSION superblobal
     *
     * @param string $sessionKey
     * @param mixed $sessionValue
     * @return void
     */
    public function createSessionData(string $sessionKey, mixed $sessionValue): void 
    {
        $_SESSION[$sessionKey] = is_array($sessionValue)
            ? (object) $sessionValue
            : $sessionValue;
    }

    /**
     * Get session key value
     *
     * @param string $sessionKey
     * @return mixed
     */
    public function getSessionKeyValue(string $sessionKey): mixed 
    {
        return $_SESSION[$sessionKey] ?? null;
    }

    /**
     * Get current session as object
     *
     * @return object
     */
    public function getSession(): object 
    {
        return (object) $_SESSION;
    }

    /**
     * Check if $_SESSION superglobal has a key
     *
     * @param string $sessionKey
     * @return boolean
     */
    public function hasSessionKey(string $sessionKey): bool 
    {
        return isset($_SESSION[$sessionKey]);
    }

    /**
     * Update session key
     *
     * @param string $sessionKey
     * @param mixed $sessionValue
     * @return void
     */
    public function updateSessionKey(string $sessionKey, mixed $sessionValue): void 
    {
        $_SESSION[$sessionKey] = is_array($sessionValue)
            ? (object) $sessionValue
            : $sessionValue;
    }

    /**
     * Delete session key
     *
     * @param string $sessionKey
     * @return void
     */
    public function deleteSessionKey(string $sessionKey): void 
    {
        unset($_SESSION[$sessionKey]);
    }

    /**
     * Delete current session
     *
     * @return void
     */
    public function deleteSession(): void 
    {
        session_destroy();
    }
}
