<?php 

declare(strict_types=1);

namespace tests\core;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\core\FlashMessage;

/**
 * Class FlashMessageTest
 *
 * @package tests\core
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
class FlashMessageTest extends TestCase
{
    /**
     * FlashMessage object for testing
     *
     * @var FlashMessage $flashMessage
     */
    private FlashMessage $flashMessage;

    /**
     * FlashMessageTest setUp
     */
    protected function setUp(): void 
    {
        $this->flashMessage = new FlashMessage();
    }

    /**
     * FlashMessage::getFlashMessage test data provider
     *
     * @return array
     */
    public static function getFlashMessageTestDataProvider(): array 
    {
        return [
            "success_message" => [
                "message content", CONF_FLASH_SUCCESS
            ],
            "danger_message" => [
                "message content", CONF_FLASH_DANGER
            ],
            "warning_message" => [
                "message content", CONF_FLASH_WARNING
            ],
            "info_message" => [
                "message content", CONF_FLASH_INFO
            ]
        ];
    }

    /**
     * Test FlashMessage::getFlashMessage 
     *
     * @param string $flashContent
     * @param string $flashType
     * @return void
     */
    #[DataProvider("getFlashMessageTestDataProvider")]
    public function testGetFlashMessage(string $flashContent, string $flashType): void 
    {
        $actual = $this->flashMessage->getFlashMessage($flashContent, $flashType);

        $this->assertMatchesRegularExpression("/alert-{$flashType}/", $actual);
    }
}

