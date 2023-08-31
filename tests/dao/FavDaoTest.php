<?php 

declare(strict_types=1);

namespace tests\dao;

use Dotenv\Dotenv;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\dao\FavDao;
use src\exceptions\FavDaoException;

/**
 * Class FavDaoTest
 *
 * @package tests\dao
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
#[RequiresPhpExtension("mysqli")]
class FavDaoTest extends TestCase
{
    /**
     * FavDao object for testing
     *
     * @var FavDao $favDao
     */
    private FavDao $favDao;

    /**
     * FavDaoTest setUp
     */
    protected function setUp(): void 
    {
        $dotenv = Dotenv::createImmutable(CONF_ENV_TEST);

        $dotenv->load();


        $this->favDao = new FavDao($_ENV["DB_TABLE_FAV"]);
    }

    /**
     * Test FavDao::getFavById test successfully
     *
     * @return void
     */
    public function testGetFavByIdSucessfully(): void 
    {
        $actual = $this->favDao->getFavById(1);

        $this->assertIsObject($actual);
        $this->assertObjectHasProperty("simple_name", $actual);
    }

    /**
     * Test FavDao::getFavById not found fav exception
     *
     * @return void
     */
    public function testGetFavByIdNotFoundException(): void 
    {
        $this->expectException(FavDaoException::class);
        $this->expectExceptionMessageMatches("/Could not find a Fav with id/");
        $this->favDao->getFavById(0);
    }

    /**
     * Test FavDao::createNewFav successfully
     *
     * @return void
     */
    public function testCreateNewFavSuccessfully(): void 
    {
        $actual = $this->favDao->createNewFav("https://www.google.com/", 2);

        $this->assertTrue($actual);
    }

    /**
     * Test FavDao::createNewFav empty URL exception
     *
     * @return void
     */
    public function testCreateNewFavEmptyUrlException(): void 
    {
        $this->expectException(FavDaoException::class);
        $this->expectExceptionMessageMatches("/Fav URL cannot be empty/");
        $this->favDao->createNewFav("", 2);
    }

    /**
     * Test FavDao::createNewFav inlivad URL
     *
     * @return void
     */
    public function testCreateNewFavInvalidUrl(): void 
    {
        $this->expectException(FavDaoException::class);
        $this->expectExceptionMessageMatches("/Invalid URL/");
        $this->favDao->createNewFav("htps;/wwwww.google.com", 2);
    }

    /**
     * Test FavDao::getAllFav for non empty array result
     *
     * @return void
     */
    public function testGetAllFavNonEmptyArray(): void 
    {
        $actual = $this->favDao->getAllFav(2);

        $this->assertIsArray($actual);
    }

    /**
     * Test FavDao::getAllFav for empty array result
     *
     * @return void
     */
    public function testGetAllFavEmptyArray(): void 
    {
        $actual = $this->favDao->getAllFav(0);

        $this->assertIsArray($actual);
    }
}
