<?php

declare(strict_types=1);

namespace tests\models;

use Dotenv\Dotenv;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\models\UserModel;

#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
#[RequiresPhpExtension("mysqli")]
class UserModelTest extends TestCase
{
    /**
     * User model object for testing
     *
     * @var UserModel
     */
    private UserModel $userModel;

    /**
     * Dummy data to test
     *
     * @var array
     */
    private array $dummyData;

    /**
     * UserModelTest setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(CONF_ENV_TEST);
        $this->dummyData = generate_dummy_user_data();

        $dotenv->load();

        $this->userModel = new UserModel();
    }

    /**
     * UserModel::loginUser test data provider
     *
     * @return array
     */
    public static function loginUserTestDataProvider(): array
    {
        return [
            "user_not_found" => [
                "notfounduser@gmail.com", "1234567890", "Failed to get user with email"
            ],
            "invalid_password" => [
                "defaultuser@gmail.com", "123", "Invalid password"
            ],
            "valid_login" => [
                "defaultuser@gmail.com", "1234567890", true
            ]
        ];
    }

    /**
     * Test UserModel::loginUser
     *
     * @param string $userEmail
     * @param string $userPassword
     * @param true|string $return
     * @return void
     */
    #[DataProvider("loginUserTestDataProvider")]
    public function testLoginUser(
        string $userEmail,
        string $userPassword,
        true|string $return
    ): void {
        $actual = $this->userModel->loginUser($userEmail, $userPassword);

        // If login fails
        if (is_string($actual)) {
            $this->assertMatchesRegularExpression("/{$return}/", $actual);
        } else {
            $this->assertEquals($return, $actual);
        }
    }

    /**
     * Test UserModel::registerUser valid user data
     *
     * @return void
     */
    public function testRegisterUserValidData(): void
    {
        $actual = $this->userModel->registerUser(
            $this->dummyData["user_email"],
            $this->dummyData["user_password"]
        );

        $this->assertIsObject($actual);
    }

    /**
     * UserModel::registerUser test for invalid password data provider
     *
     * @return array
     */
    public static function registerUserTestInvalidPasswordDataProvider(): array
    {
        return [
            "invalid_min_len" => [
                "123",
                "Invalid password"
            ],
            "invalid_max_len" => [
                "999999999999999999999999999999999999999999999999999999999999999",
                "Invalid password"
            ]
        ];
    }

    /**
     * Test UserModel::registerUser test for invalid password
     *
     * @param string $password
     * @param string $expectedMessage
     * @return void
     */
    #[DataProvider("registerUserTestInvalidPasswordDataProvider")]
    public function testRegsiterPasswordInvalidPassword(
        string $password,
        string $expectedMessage
    ): void
    {
        $actual = $this->userModel->registerUser(
            $this->dummyData["user_email"],
            $password
        );

        $this->assertMatchesRegularExpression("/{$expectedMessage}/", $actual);
    }
}
