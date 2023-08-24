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
            "user_email={$validatedEmail}"
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
     * @return object
     */
    public function createUser(string $userEmail, string $userPassword): object
    {
        // Validate password
        if (!validate_password($userPassword)) {
            throw new UserDaoException("Invalid password");
        }

        // Mount user data array
        $newUserData = [
            "user_email" => validate_email($userEmail),
            "user_password" => encrypt_password($userPassword)
        ];

        $result = $this->createData($newUserData);

        // Failed to create new user in database
        if (!is_string($result)) {
            throw new UserDaoException("Failed to create new user with email {$result}");
        }

        // Return new user
        return $this->getUserByEmail($userEmail);
    }
}
