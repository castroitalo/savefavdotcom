<?php

declare(strict_types=1);

namespace tests\core;

use PDO;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\core\DBConnection;
use Dotenv\Dotenv;

/**
 * Class DBConnectionTest 
 * 
 * @package src\core
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
#[RequiresPhpExtension("mysqli")]
class DBConnectionTest extends TestCase
{
    /**
     * DBConnectionTest setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(CONF_ROOT_DIR);

        $dotenv->load();
    }

    /**
     * Test DBConnection::getConnection
     *
     * @return void
     */
    public function testDbConnection(): void
    {
        $this->assertInstanceOf(PDO::class, DBConnection::getConnection());
    }

    /**
     * Test DBConnection::getConnection singleton connection
     *
     * @return void
     */
    public function testSingletonDbConnection(): void 
    {
        $connOne = DBConnection::getConnection();
        $connTwo = DBConnection::getConnection();

        $this->assertSame($connOne, $connTwo);
    }
}
