<?php 

declare(strict_types=1);

namespace tests\core;

use src\core\Router;

/**
 * Class RouterTestBuilder
 * 
 * @package test\core
 */
final class RouterTestBuilder
{
    /**
     * Dummy routes for RouterTest
     *
     * @return array
     */
    public static function dummyRoutes(): array
    {
        $router = new Router();

        $router->addRoute(
            "GET",
            "/route_one",
            "Controller@method"
        );
        $router->addRoute(
            "GET",
            "/route_two",
            "Controller@method",
            "Middleware@method"
        );
        $router->addRoute(
            "GET",
            "/route_three/(:alpha)",
            "Controller@method"
        );
        $router->addRoute(
            "GET",
            "/route_four/(:numeric)",
            "Controller@method"
        );
        $router->addRoute(
            "GET",
            "/route_five/(:alphanumeric)",
            "Controller@method"
        );
        $router->addRoute(
            "GET",
            "/route_six/(:alpha)/id/(:numeric)",
            "Controller@method"
        );
        $router->addRoute(
            "POST",
            "/route_seven",
            "Controller@method"
        );
        $router->addRoute(
            "POST",
            "/route_eight",
            "Controller@method",
            "Middleware@method"
        );
        $router->addRoute(
            "POST",
            "/route_nine/(:alphanumeric)",
            "Controller@method"
        );

        return $router->getRoutes();
    }
}
