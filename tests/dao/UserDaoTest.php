<?php

declare(strict_types=1);

namespace tests\dao;

use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use src\dao\UserDao;
use src\exceptions\UserDaoException;

/**
 * Class UserDaoTest
 * 
 * @package tests\dao
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
#[RequiresPhpExtension("mysqli")]
final class UserDaoTest extends TestCase
{
    /**
     * UserDao instance for test
     *
     * @var UserDao
     */
    private UserDao $userDao;

    /**
     * Dummy data for tests
     *
     * @var array
     */
    private array $dummyData;

    /**
     * UserDaoTest setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(CONF_ENV_TEST);
        $this->dummyData = generate_dummy_user_data();

        $dotenv->load();

        $this->userDao = new UserDao($_ENV["DB_TABLE_USERS"]);
    }

    /**
     * Test UserDao::getUserById succesfully
     *
     * @return void
     */
    public function testGetUserByIdSuccessfully(): void
    {
        $actual = $this->userDao->getUserById(1);

        $this->assertIsObject($actual);
    }

    /**
     * Test UserData::getUserById user not found exception
     *
     * @return void
     */
    public function testGetUserByIdNotFoundUserException(): void
    {
        $this->expectException(UserDaoException::class);
        $this->expectExceptionMessageMatches("/Failed to get user with id/");
        $this->userDao->getUserById(0);
    }

    /**
     * Test UserDao::getUserByEmail successfully
     *
     * @return void
     */
    public function testGetUserByEmailSuccessfully(): void
    {
        $actual = $this->userDao->getUserByEmail("newuser@gmail.com");

        $this->assertIsObject($actual);
    }

    /**
     * Test UserDao::getUserByEmail user not found exception
     *
     * @return void
     */
    public function testGetUserByEmailNotFoundUserException(): void
    {
        $this->expectException(UserDaoException::class);
        $this->expectExceptionMessageMatches("/Failed to get user with email/");
        $this->userDao->getUserByEmail("notfounduserexception@gmail.com");
    }

    /**
     * Test UserDao::createUser successfully
     *
     * @return void
     */
    public function testCreateUserSuccessfully(): void
    {
        $actual = $this->userDao->createUser(
            $this->dummyData["user_email"],
            $this->dummyData["user_password"]
        );

        $this->assertIsObject($actual);
    }

    /**
     * UserDao::createUser invalid password exception test data provider
     *
     * @return array
     */
    public static function createUserTestInavlidPasswordExceptionDataProvider(): array
    {
        return [
            "invalid_password_min_len" => [
                "123"
            ],
            "invalid_password_max_len" => [
                "99999999999999999999999999999999999999999999999999999999999999"
            ],
        ];
    }

    /**
     * Test UserDao::createUser invalid password exception
     *
     * @param string $userPassword
     * @return void
     */
    #[DataProvider("createUserTestInavlidPasswordExceptionDataProvider")]
    public function testCreateUserInvalidPasswordException(string $userPassword): void {
        $this->expectException(UserDaoException::class);
        $this->expectExceptionMessageMatches("/Invalid password/");
        $this->userDao->createUser("email@gmail.com", $userPassword);
    }
}
