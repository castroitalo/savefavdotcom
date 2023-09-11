<?php

declare(strict_types=1);

namespace src\models;

use src\dao\UserDao;
use src\exceptions\UserDaoException;

/**
 * Class UserModel
 * 
 * @package src\models
 */
final class UserModel
{
    /**
     * User dao to make database operations
     *
     * @var UserDao
     */
    private UserDao $userDao;

    /**
     * UserModel construcotor
     */
    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    /**
     * Login user in the platform
     *
     * @param string $userEmail
     * @param string $userPassword
     * @return object|string
     */
    public function loginUser(string $userEmail, string $userPassword): object|string
    {
        // Try to get user in database
        try {
            $validatedEmail = validate_email($userEmail);
            $user = $this->userDao->getUserByEmail($validatedEmail);
        } catch (UserDaoException $ex) {
            return $ex->getMessage();
        }

        // Check password to login 
        if (!password_verify($userPassword, $user->user_password)) {
            return "Invalid password";
        }

        return $user;
    }

    /**
     * Activate user email
     *
     * @param string $userEmail
     * @param string $userActivationToken
     * @return object|string
     */
    public function activateUserEmail(
        string $userEmail,
        string $userActivationToken
    ): object|string {
        try {
            // Before activation
            $user = $this->userDao->getUserByActivationToken(
                $userEmail,
                $userActivationToken
            );

            if ($user) {
                $this->userDao->updateUserActivationStatus($userEmail);
            }

            // After activation
            return $this->userDao->getUserByActivationToken(
                $userEmail,
                $userActivationToken
            );
        } catch (UserDaoException $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Update user email
     *
     * @param string $currentUserEmail
     * @param string $newUserEmail
     * @return bool|string
     */
    public function updateUserDataEmail(
        string $currentUserEmail,
        string $newUserEmail
    ): bool|string {
        try {
            $updatedUserEmail = $this->userDao->updateUserEmail(
                $currentUserEmail,
                $newUserEmail
            );

            return $updatedUserEmail;
        } catch (UserDaoException $ex) {
            return $ex->getMEssage();
        }
    }

    public function updateUserDataPassword(
        string $userEmail,
        string $userPassword
    ): bool|string {
        try {
            $updatedUserPassword = $this->userDao->updateUserPassword(
                $userEmail,
                $userPassword
            );

            return $updatedUserPassword;
        } catch (UserDaoException $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Register new user
     *
     * @param string $userEmail
     * @param string $userPassword
     * @return object|string
     */
    public function registerUser(string $userEmail, string $userPassword): object|string
    {
        try {
            $newUser = $this->userDao->createUser($userEmail, $userPassword);

            return $newUser;
        } catch (UserDaoException $ex) {
            return $ex->getMessage();
        }
    }
}
