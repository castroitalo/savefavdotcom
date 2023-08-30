<?php 

declare(strict_types=1);

namespace tests\models;

use Dotenv\Dotenv;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\models\FavModel;

/**
 * Class FavModelTest
 * 
 * @package tests\models
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
#[RequiresPhpExtension("mysqli")]
final class FavModelTest extends TestCase
{
    private FavModel $favModel;

    protected function setUp(): void 
    {
        $dotenv = Dotenv::createImmutable(CONF_ENV_TEST);
        
        $dotenv->load();

        $this->favModel = new FavModel();
    }

    /**
     * FavModel::createFav test data provider
     *
     * @return array
     */
    public static function createFavTestDataProvider(): array 
    {
        return [
            "https_and_www" => [
                "https://www.site.com"
            ],
            "https_not_www" => [
                "https://site.com"
            ],
            "http_and_www" => [
                "http://www.site.com"
            ],
            "http_not_www" => [
                "http://site.com"
            ]
        ];
    } 

    /**
     * Test FavModel::createFav successfully
     *
     * @param string $favUrl
     * @return void
     */
    #[DataProvider("createFavTestDataProvider")]
    public function testCreateFav(string $favUrl): void 
    {
        $actual = $this->favModel->createFav($favUrl, 2);

        $this->assertTrue($actual);
    }
}
