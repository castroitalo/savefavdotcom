<?php

declare(strict_types=1);

namespace tests\core;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\core\View;
use src\exceptions\ViewException;

/**
 * Class ViewTest
 * 
 * @package tests\core
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
final class ViewTest extends TestCase
{
    /**
     * View::renderView exception test data provider
     *
     * @return array
     */
    public static function renderViewExceptionsTestProvider(): array
    {
        return [
            "view_key_not_set" => [
                [
                    "pageData" => []
                ],
                "View::renderView \$viewData parameter do not have a 'view' key"
            ],
            "view_file_dont_exists" => [
                [
                    "view" => "/dontexists.view.php",
                    "pageData" => []
                ],
                "file do not exists"
            ],
            "view_title_key_not_set" => [
                [
                    "view" => "/homepage.view.php",
                    "pageData" => []
                ],
                "View's title is not set"
            ],
            "view_title_key_empty" => [
                [
                    "view" => "/homepage.view.php",
                    "pageData" => [
                        "title" => ""
                    ]
                ],
                "View's title is empty"
            ],
            "view_style_key_not_set" => [
                [
                    "view" => "/homepage.view.php",
                    "pageData" => [
                        "title" => "Page Title"
                    ]
                ],
                "View's style file is missing"
            ],
            "view_script_key_not_set" => [
                [
                    "view" => "/homepage.view.php",
                    "pageData" => [
                        "title" => "Page Title",
                        "viewStyle" => "/homepage.css"
                    ]
                ],
                "View's script file is missing"
            ],
        ];
    }

    /**
     * Test View::renderView exceptions
     *
     * @param array $viewData
     * @param string $exceptionExpectedMessage
     * @return void
     */
    #[DataProvider("renderViewExceptionsTestProvider")]
    public function testRenderViewExceptions(
        array $viewData,
        string $exceptionExpectedMessage
    ): void {
        $this->expectException(ViewException::class);
        $this->expectExceptionMessage($exceptionExpectedMessage);
        View::renderView($viewData);
    }
}
