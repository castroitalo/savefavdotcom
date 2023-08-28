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
     * @return true|string
     */
    public function loginUser(string $userEmail, string $userPassword): true|string 
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

        return true;
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
