<?php 

declare(strict_types=1);

namespace tests\dao;

use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
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
     * UserDaoTest setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(CONF_ENV_TEST);
        
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
    public function testGetUserByIdException(): void 
    {
        $this->expectException(UserDaoException::class);
        $this->expectExceptionMessageMatches("/Failed to get user with id/");
        $this->userDao->getUserById(0);
    }
}
