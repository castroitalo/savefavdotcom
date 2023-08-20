<?php

declare(strict_types=1);

namespace tests\dao;

use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use src\dao\BaseDao;

/**
 * Class BaseDaoTest
 * 
 * @package tests\dao
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
// #[RequiresPhpExtension("mysqli")]
final class BaseDaoTest extends TestCase
{
    /**
     * BaseDao instance for test
     *
     * @var BaseDao
     */
    private BaseDao $baseDao;

    /**
     * DBConnectionTest setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(CONF_ROOT_DIR);
        $this->baseDao = new BaseDao($_ENV["DB_TABLE_USERS"]);

        $dotenv->load();
    }

    /**
     * 
     * TODO - BaseDao::readAll TEST USING MOCKERY TO SIMULATE DBConnection
     * 
     */
}
