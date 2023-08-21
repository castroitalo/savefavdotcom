<?php

declare(strict_types=1);

namespace tests\dao;

use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use PHPUnit\Framework\Attributes\DataProvider;
use src\core\DBConnection;
use src\dao\BaseDao;
use src\exceptions\BaseDaoException;
use stdClass;

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

        $dotenv->load();

        $this->baseDao = new BaseDao($_ENV["DB_TABLE_USERS"]);
    }

    /**
     * BaseDao::readAll test data provider
     *
     * @return array
     */
    public static function readAllResultsFoundTestDataProvider(): array
    {
        return [
            "default_where_default_params_default_columns" => [
                null, null, "*"
            ],
            "default_where_default_params_custom_columns" => [
                null, null, "user_id"
            ],
            "custom_where_custom_params_defualt_columns" => [
                "WHERE user_id=:user_id", "user_id=" . 1, "*"
            ],
            "custom_where_custom_params_custom_columns" => [
                "WHERE user_id=:user_id", "user_id=" . 1, "user_id"
            ],
        ];
    }

    /**
     * Test BaseDao::readAll test
     *
     * @param string|null $where
     * @param string|null $params
     * @param string $columns
     * @return void
     */
    #[DataProvider("readAllResultsFoundTestDataProvider")]
    public function testReadAllFoundResults(
        ?string $where,
        ?string $params,
        string $columns
    ): void {
        $actual = $this->baseDao->readAll($where, $params, $columns);

        $this->assertIsArray($actual);
    }

    /**
     * Test BaseDao::readAll for no results found
     *
     * @return void
     */
    public function testReadAllNoResultFound(): void 
    {
        $where = "WHERE user_id=:user_id";
        $params = "user_id=" . 0;
        $actual = $this->baseDao->readAll($where, $params);

        $this->assertEmpty($actual);
    }

    /**
     * BaseDao::readAll test data provider
     *
     * @return array
     */
    public static function readAllTestExceptionsDataProvider(): array
    {
        return [
            "where_without_params" => [
                "WHERE user_id=:user_id",
                null,
                "*",
                "Cannot use WHERE statement without parameters."
            ],
            "no_where_with_params" => [
                null,
                "user_id=" . 1,
                "*",
                "Cannot use parameters without a WHERE statement."
            ]
        ];
    }

    /**
     * Test BaseDao::readAll exceptions
     *
     * @param string|null $where
     * @param string|null $params
     * @param string $columns
     * @param string $expectExceptionMessage
     * @return void
     */
    #[DataProvider("readAllTestExceptionsDataProvider")]
    public function testReadAllExceptions(
        ?string $where,
        ?string $params,
        string $columns,
        string $expectExceptionMessage
    ): void {
        $this->expectException(BaseDaoException::class);
        $this->expectExceptionMessageMatches("/{$expectExceptionMessage}/");
        $this->baseDao->readAll($where, $params, $columns);
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function readByFoundResultTestDataProvider(): array
    {
        return [
            "where_params_default_columns" => [
                "WHERE user_id=:user_id", 
                "user_id=" . 1, 
                "*"
            ],
            "where_params_custom_columns" => [
                "WHERE user_id=:user_id",
                "user_id=" . 1,
                "user_id"
            ],
        ];
    }

    /**
     * Test BaseDao::readAll for found results
     *
     * @param string|null $where
     * @param string|null $params
     * @param string $columns
     * @return void
     */
    #[DataProvider("readByFoundResultTestDataProvider")]
    public function testReadByFoundResult(
        ?string $where,
        ?string $params,
        string $columns,
    ): void {
        $actual = $this->baseDao->readBy($where, $params, $columns);

        $this->assertInstanceOf(stdClass::class, $actual);
    }

    /**
     * Test BaseDao::readBy for no results found
     *
     * @return void
     */
    public function testReadByNotFoundResult(): void 
    {
        $where = "WHERE user_id=:user_id";
        $params = "user_id=" . 0;
        $actual = $this->baseDao->readBy($where, $params);

        $this->assertFalse($actual);
    }
}
