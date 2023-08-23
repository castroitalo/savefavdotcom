<?php

declare(strict_types=1);

namespace src\dao;

use src\core\DBConnection;
use src\exceptions\UserDaoException;

/**
 * Class UserDao
 *
 * @package src\dao
 */
final class UserDao extends BaseDao
{
    /**
     * UserDao constructor 
     */
    public function __construct(?string $userTable = null)
    {
        parent::__construct(
            $userTable ?? $_ENV["DB_TABLE_USERS"],
            DBConnection::getConnection()
        );
    }

    /**
     * Get user from database based on it's id
     *
     * @param integer $userId
     * @return object
     */
    public function getUserById(int $userId): object
    {
        $user = $this->readDataBy(
            "WHERE user_id=:user_id",
            "user_id={$userId}"
        );

        // If none user were found
        if (!$user) {
            throw new UserDaoException("Failed to get user with id {$userId}");
        }

        return $user;
    }

    /**
     * Get user from database based on it's email
     *
     * @param string $userEmail
     * @return object
     */
    public function getUserByEmail(string $userEmail): object
    {
        $validatedEmail = validate_email($userEmail);
        $user = $this->readDataBy(
            "WHERE user_email=:user_email",
            "user_email='{$validatedEmail}'"
        );

        // If none user were found
        if (!$user) {
            throw new UserDaoException("Failed to get user with email {$userEmail}");
        }

        return $user;
    }

    /**
     * Create a new user in database
     *
     * @param string $userEmail
     * @param string $userPassword
     * @return void
     */
    public function createUser(string $userEmail, string $userPassword)
    {
        // Validate password
        if (!validate_password($userPassword)) {
            throw new UserDaoException("Invalid password");
        }

        $userData = [
            "user_email" => validate_email($userEmail),
            "user_password" => encrypt_password($userPassword)
        ];

        // TODO
    }
}
