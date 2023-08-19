<?php

declare(strict_types=1);

namespace tests\models;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;
use src\models\Route;

/**
 * Class RouteTest 
 * 
 * @package tests\models
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
final class RouteTest extends TestCase
{
    public static function routeAssignmentPropertyTestDataProvider(): array
    {
        return [
            "without_middleware_get_method" => [
                "GET",
                "/route",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "controllerMethod"
                ],
                null
            ],
            "without_middleware_post_method" => [
                "POST",
                "/route",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "controllerMethod"
                ],
                null
            ],
            "without_middleware_put_method" => [
                "PUT",
                "/route",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "controllerMethod"
                ],
                null
            ],
            "without_middleware_patch_method" => [
                "PATCH",
                "/route",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "controllerMethod"
                ],
                null
            ],
            "without_middleware_delete_method" => [
                "DELETE",
                "/route",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "controllerMethod"
                ],
                null
            ],
            "with_middleware_get_method" => [
                "GET",
                "/route",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "controllerMethod"
                ],
                [
                    "callback_class" => "Middleware",
                    "callback_method" => "middlewareMethod"
                ]
            ],
            "with_middleware_post_method" => [
                "POST",
                "/route",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "controllerMethod"
                ],
                [
                    "callback_class" => "Middleware",
                    "callback_method" => "middlewareMethod"
                ]
            ],
            "with_middleware_put_method" => [
                "PUT",
                "/route",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "controllerMethod"
                ],
                [
                    "callback_class" => "Middleware",
                    "callback_method" => "middlewareMethod"
                ]
            ],
            "with_middleware_patch_method" => [
                "PATCH",
                "/route",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "controllerMethod"
                ],
                [
                    "callback_class" => "Middleware",
                    "callback_method" => "middlewareMethod"
                ]
            ],
            "with_middleware_delete_method" => [
                "DELETE",
                "/route",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "controllerMethod"
                ],
                [
                    "callback_class" => "Middleware",
                    "callback_method" => "middlewareMethod"
                ]
            ],
        ];
    }

    /**
     * Test Route::__construct with/without middleware
     *
     * @param string $routeHttpMethod
     * @param string $routeUriPath
     * @param array $routeController
     * @param array|null $routeMiddleware
     * @return void
     */
    #[DataProvider("routeAssignmentPropertyTestDataProvider")]
    public function testRouteAssignmentProperty(
        string $routeHttpMethod,
        string $routePath,
        array $routeController,
        ?array $routeMiddleware
    ): void {
        $route = new Route(
            $routeHttpMethod,
            $routePath,
            $routeController,
            $routeMiddleware
        );

        // Test if property was assign correctly
        $this->assertObjectHasProperty("routeHttpMethod", $route);
        $this->assertObjectHasProperty("routePath", $route);
        $this->assertObjectHasProperty("routeController", $route);
        $this->assertObjectHasProperty("routeMiddleware", $route);

        // Test if the property values was assign correctly
        $this->assertEquals($route->getRouteHttpMethod(), $routeHttpMethod);
        $this->assertEquals($route->getRoutePath(), $routePath);
        $this->assertEquals($route->getRouteController(), $routeController);
        $this->assertEquals($route->getRouteMiddleware(), $routeMiddleware);
    }
}
