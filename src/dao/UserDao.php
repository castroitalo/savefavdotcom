<?php

declare(strict_types=1);

namespace src\dao;

use src\core\DBConnection;
use src\core\Mailer;
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
     *
     * @param ?string $userTable
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
        $user = $this->readDataBy("WHERE user_id=:user_id", "user_id={$userId}");

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
     * Get user by activation code and email
     *
     * @param string $userEmail
     * @param string $userActivationToken
     * @return object
     */
    public function getUserByActivationToken(
        string $userEmail,
        string $userActivationToken
    ): object {
        $validatedEmail = validate_email($userEmail);
        $user = $this->readDataBy(
            "WHERE user_email=:user_email AND user_activation_code=:user_activation_code",
            "user_email={$validatedEmail}&user_activation_code={$userActivationToken}"
        );

        // User not found
        if (!$user) {
            throw new UserDaoException("Failed to activate user");
        }

        return $user;
    }

    /**
     * Sends email confirmation to new user
     *
     * @param string $userEmail
     * @param string $activationToken
     * @return bool
     */
    public function sendActivationEmail(
        string $userEmail,
        string $activationToken
    ): bool {
        $mailer = new Mailer();
        $activationUrl = get_url("/activate-user?email={$userEmail}&token={$activationToken}");
        $emailContent = $mailer::getEmailTemplate(
            "/email_activation.template.html",
            [
                "@userEmail" => $userEmail,
                "@activationUrl" => $activationUrl
            ]
        );

        return $mailer::sendEmail(
            $userEmail,
            $userEmail,
            "Email activation",
            $emailContent,
            $emailContent
        );
    }

    /**
     * Update user activation status to 1
     *
     * @param string $userEmail
     * @return bool
     */
    public function updateUserActivationStatus(string $userEmail): bool
    {
        $updated = $this->updateData(
            [
                "user_active" => 1,
                "user_activated_at" => date('Y-m-d H:i:s',  time())
            ],
            " WHERE user_email='{$userEmail}'"
        );

        if (!$updated) {
            throw new UserDaoException("Failed to activate user.");
        }

        return $updated;
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

        $emailActivationToken = bin2hex(random_bytes(16));
        // Mount user data array
        $newUserData = [
            "user_email" => validate_email($userEmail),
            "user_password" => encrypt_password($userPassword),
            "user_activation_code" => $emailActivationToken,
            "user_activation_expiry" => date('Y-m-d H:i:s',  time() + CONF_EMAIL_CONFIRM_EXPIRY_TIME)
        ];

        $result = $this->createData($newUserData);

        // Failed to create new user in database
        if (!is_string($result)) {
            throw new UserDaoException("Failed to create new user with email {$result}");
        }

        $this->sendActivationEmail($userEmail, $emailActivationToken);

        // Return new user
        return $this->getUserByEmail($userEmail);
    }
}
