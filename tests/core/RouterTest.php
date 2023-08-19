<?php

declare(strict_types=1);

namespace tests\core;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use src\core\Router;
use src\exceptions\RouterException;
use src\models\Route;

/**
 * Class RouterTest
 * 
 * @package tests\core
 */
#[RequiresPhp("8.2")]
#[RequiresPhpunit("10.3")]
final class RouterTest extends TestCase
{
    /**
     * Base router object for tests
     *
     * @var Router
     */
    private Router $router;

    /**
     * Setup new Router object to $this->router
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->router = new Router();
    }

    /**
     * Test Router property assignments for default callback separator
     *
     * @return void
     */
    public function testRouterPropertyAssignmentDefaultCallbackSeparator(): void
    {
        $this->assertObjectHasProperty("routes", $this->router);
        $this->assertObjectHasProperty("callbackSeparator", $this->router);
    }

    /**
     * Test Router property assignments for custom callback separator
     *
     * @return void
     */
    public function testRouterPropertyAssignmentCustomCallbackSeparator(): void
    {
        $this->router = new Router("#");

        $this->assertObjectHasProperty("routes", $this->router);
        $this->assertObjectHasProperty("callbackSeparator", $this->router);
    }

    /**
     * Test Router::extractCallbackInfo data provider
     *
     * @return array
     */
    public static function extractCallbackInfoTestProvider(): array
    {
        return [
            "empty_string" => [
                "",
                []
            ],
            "valid_string" => [
                "Controller@method",
                [
                    "callback_class" => "Controller",
                    "callback_method" => "method"
                ]
            ]
        ];
    }

    /**
     * Test Router::extractCallbackInfo 
     *
     * @return void
     */
    #[DataProvider("extractCallbackInfoTestProvider")]
    public function testRouterExtractCallbackInfoValidString(
        string $callbackString,
        array $expected
    ): void {
        $actual = $this->router->extractCallbackInfo($callbackString);

        $this->assertSame($expected, $actual);
    }

    /**
     * Data provider for Router::addRoute exceptions test
     *
     * @return array
     */
    public static function addRouteExceptionTestProvider(): array
    {
        return [
            "invalid_http_method_exception" => [
                "INVALID",
                "/",
                "Controller@method",
                "",
                "Invalid route HTTP method value"
            ],
            "empty_http_method_exception" => [
                "",
                "/",
                "Controller@method",
                "",
                "Invalid route HTTP method value"
            ],
            "empty_route_path_exception" => [
                "GET",
                "",
                "Controller@method",
                "",
                "Route path cannot be empty"
            ],
            "empty_route_controller_exception" => [
                "GET",
                "/",
                "",
                "",
                "Invalid route controller"
            ],
            "controller_with_wrong_separator_exception" => [
                "GET",
                "/",
                "Controller#method",
                "",
                "Invalid route controller separator"
            ],
            "middleware_with_wrong_separator_exception" => [
                "GET",
                "/",
                "Controller@method",
                "Middleware#method",
                "Invalid route middleware separator"
            ]
        ];
    }

    /**
     * Test Router::addRoute exceptions
     *
     * @param string $routeHttpMethod
     * @param string $routePath
     * @param string $routeController
     * @param string $routeMiddleware
     * @param string $expectedExcetionMessage
     * @return void
     */
    #[DataProvider("addRouteExceptionTestProvider")]
    public function testAddRouteExceptions(
        string $routeHttpMethod,
        string $routePath,
        string $routeController,
        string $routeMiddleware,
        string $expectedExcetionMessage
    ): void {
        $this->expectException(RouterException::class);
        $this->expectExceptionMessageMatches("/{$expectedExcetionMessage}/");
        $this->router->addRoute(
            $routeHttpMethod,
            $routePath,
            $routeController,
            $routeMiddleware
        );
    }

    /**
     * Router::addRoute test for valid input provider
     *
     * @return array
     */
    public static function addRouteValidInputTestProvider(): array
    {
        return [
            "valid_get_route_without_middleware" => [
                "GET",
                "/",
                "Controller@method",
                "",
                1
            ],
            "valid_get_route_with_middleware" => [
                "GET",
                "/",
                "Controller@method",
                "Middleware@method",
                1
            ],
            "valid_post_route_without_middleware" => [
                "POST",
                "/",
                "Controller@method",
                "",
                1
            ],
            "valid_post_route_with_middleware" => [
                "POST",
                "/",
                "Controller@method",
                "Middleware@method",
                1
            ]
        ];
    }

    /**
     * Test Router::addRoute for valid inputs
     *
     * @param string $routeMethod
     * @param string $routePath
     * @param string $routeController
     * @param string $routeMiddleware
     * @param integer $expected
     * @return void
     */
    #[DataProvider("addRouteValidInputTestProvider")]
    public function testAddRouteValidInput(
        string $routeMethod,
        string $routePath,
        string $routeController,
        string $routeMiddleware,
        int $expected
    ): void {
        $this->router->addRoute(
            $routeMethod,
            $routePath,
            $routeController,
            $routeMiddleware
        );

        $actual = count($this->router->getRoutes()[$routeMethod]);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Router::matchFixedUri test data provider
     *
     * @return array
     */
    public static function matchFixedUriTestProvider(): array
    {
        return [
            "empty_routes_exception" => [
                "/",
                [],
                null
            ],
            "unexistent_request_uri_exception" => [
                "/dontexists",
                RouterTestBuilder::dummyRoutes()["GET"],
                null
            ],
            "valid_request_uri" => [
                "/route_one",
                RouterTestBuilder::dummyRoutes()["GET"],
                new Route(
                    "GET",
                    "/route_one",
                    [
                        "callback_class" => "Controller",
                        "callback_method" => "method"
                    ]
                )
            ]
        ];
    }

    /**
     * Test Router::matchFixedUri
     *
     * @param string $requestUri
     * @param array $routes
     * @param Route|null $expected
     * @return void
     */
    #[DataProvider("matchFixedUriTestProvider")]
    public function testMatchFixedUri(
        string $requestUri,
        array $routes,
        Route|null $expected
    ): void {
        $actual = $this->router->matchFixedUri($requestUri, $routes);

        if ($expected) {
            $this->assertInstanceOf(Route::class, $actual);
        } else {

            $this->assertNull($actual);
        }
    }

    /**
     * Router::matchDynamicUri test data provider
     *
     * @return array
     */
    public static function matchDynamicUriTestProvider(): array
    {
        return [
            "empty_routes" => [
                "/",
                [],
                null
            ],
            "unexistent_request_uri" => [
                "/dontexists",
                RouterTestBuilder::dummyRoutes()["GET"],
                null
            ],
            "valid_request_uri_alpha_pattern" => [
                "/route_three/alpha",
                RouterTestBuilder::dummyRoutes()["GET"],
                new Route(
                    "GET",
                    "/route_three/(:alpha)",
                    [
                        "callback_class" => "Controller",
                        "callback_method" => "method"
                    ]
                )
            ],
            "valid_request_uri_numeric_pattern" => [
                "/route_four/123",
                RouterTestBuilder::dummyRoutes()["GET"],
                new Route(
                    "GET",
                    "/route_four/(:numeric)",
                    [
                        "callback_class" => "Controller",
                        "callback_method" => "method"
                    ]
                )
            ],
            "valid_request_uri_alphanumeric_pattern" => [
                "/route_five/alpha123",
                RouterTestBuilder::dummyRoutes()["GET"],
                new Route(
                    "GET",
                    "/route_five/(:alphanumeric)",
                    [
                        "callback_class" => "Controller",
                        "callback_method" => "method"
                    ]
                )
            ],
            "valid_request_uri_multiple_patterns" => [
                "/route_six/alpha/id/1",
                RouterTestBuilder::dummyRoutes()["GET"],
                new Route(
                    "GET",
                    "/route_six/(:alpha)/id/(:numeric)",
                    [
                        "callback_class" => "Controller",
                        "callback_method" => "method"
                    ]
                )
            ]
        ];
    }

    /**
     * Test Router::matchDynamicUri
     *
     * @param string $requestUri
     * @param array $routes
     * @param Route|null $expected
     * @return void
     */
    #[DataProvider("matchDynamicUriTestProvider")]
    public function testMatchDynamicUri(
        string $requestUri,
        array $routes,
        Route|null $expected
    ): void {
        $actual = $this->router->matchDynamicUri($requestUri, $routes);

        if ($expected) {
            $this->assertInstanceOf(Route::class, $actual);
        } else {

            $this->assertNull($actual);
        }
    }

    /**
     * Test Router::getDynamicUriParameters test data provider
     *
     * @return array
     */
    public static function getDyanmicUriParametersTestProvider(): array
    {
        return [
            "alpha_pattern_params" => [
                "/route/alphachars",
                new Route(
                    "GET",
                    "/route/(:alpha)",
                    [
                        "controller_class" => "Controller",
                        "controller_method" => "method"
                    ]
                ),
                [
                    "route" => "alphachars"
                ]
            ],
            "numeric_pattern_params" => [
                "/route/123",
                new Route(
                    "GET",
                    "/route/(:numeric)",
                    [
                        "controller_class" => "Controller",
                        "controller_method" => "method"
                    ]
                ),
                [
                    "route" => "123"
                ]
            ],
            "alphanumeric_pattern_params" => [
                "/route/alpha123",
                new Route(
                    "GET",
                    "/route/(:alphanumeric)",
                    [
                        "controller_class" => "Controller",
                        "controller_method" => "method"
                    ]
                ),
                [
                    "route" => "alpha123"
                ]
            ],
            "multiples_pattern_params" => [
                "/alphanumeric/alpha123/alpha/user/numeric/123",
                new Route(
                    "GET",
                    "/alphanumeric/(:alphanumeric)/alpha/(:alpha)/numeric/(:numeric)",
                    [
                        "controller_class" => "Controller",
                        "controller_method" => "method"
                    ]
                ),
                [
                    "alphanumeric" => "alpha123",
                    "alpha" => "user",
                    "numeric" => "123"
                ]
            ]
        ];
    }

    /**
     * Test Router::getDynamicUriParameters
     *
     * @return void
     */
    #[DataProvider("getDyanmicUriParametersTestProvider")]
    public function testGetDynamicUriParameters(
        string $requestRoute,
        Route $foundRoute,
        array $expected
    ): void {
        $actual = $this->router->getDynamicUriParameters($requestRoute, $foundRoute);

        $this->assertSame($expected, $actual);
    }

    /**
     * Router::executeRouteController test data provider
     *
     * @return array
     */
    public static function executeRouteControllerExceptionTestProvider(): array
    {
        return [
            "unexistent_controller_class_exception" => [
                new Route(
                    "GET",
                    "/",
                    [
                        "callback_class" => "UnexistentController",
                        "callback_method" => "unexistentMethod"
                    ]
                ),
                "Route controller class: "
            ],
            "unexistent_controller_method_exception" => [
                new Route(
                    "GET",
                    "/",
                    [
                        "callback_class" => "HomeController",
                        "callback_method" => "unexistentMethod"
                    ]
                ),
                "Route controller method: "
            ]
        ];
    }

    /**
     * Test Router::executeRouteController 
     *
     * @param Route $foundRoute
     * @param string $expectedExcetionMessage
     * @return void
     */
    #[DataProvider("executeRouteControllerExceptionTestProvider")]
    public function testExecuteRouteControllerExceptions(
        Route $foundRoute,
        string $expectedExcetionMessage
    ): void {
        $this->expectException(RouterException::class);
        $this->expectExceptionMessage($expectedExcetionMessage);
        $this->router->executeRouteController($foundRoute, []);
    }

    /**
     * Router::executeRouteMiddleware test data provider
     *
     * @return array
     */
    public static function executeRouteMiddlewareExceptionTestProvider(): array
    {
        return [
            "unexistent_middleware_class_exception" => [
                new Route(
                    "GET",
                    "/",
                    [
                        "callback_class" => "HomeController",
                        "callback_method" => "homepage"
                    ],
                    [
                        "callback_class" => "UnexistentMiddleware",
                        "callback_method" => "method"
                    ]
                ),
                "Route middleware class: "
            ],
            "unexistent_middleware_method_exception" => [
                new Route(
                    "GET",
                    "/",
                    [
                        "callback_class" => "HomeController",
                        "callback_method" => "homepage"
                    ],
                    [
                        "callback_class" => "AuthMiddleware",
                        "callback_method" => "unexistentMethod"
                    ]
                ),
                "Route middleware method: "
            ]
        ];
    }

    /**
     * Test Router::executeRouteMiddleware
     *
     * @param Route $foundRoute
     * @param string $expectedExcetionMessage
     * @return void
     */
    #[DataProvider("executeRouteMiddlewareExceptionTestProvider")]
    public function testExecuteRouteMiddlewareExceptions(
        Route $foundRoute,
        string $expectedExcetionMessage
    ): void {
        $this->expectException(RouterException::class);
        $this->expectExceptionMessage($expectedExcetionMessage);
        $this->router->executeRouteMiddleware($foundRoute);
    }
}
