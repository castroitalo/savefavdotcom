<?php

declare(strict_types=1);

namespace src\core;

use src\exceptions\RouterException;
use src\models\Route;

/**
 * Class Router
 * 
 * @package src\core
 */
final class Router
{
    /**
     * App's defined routes
     *
     * @var array
     */
    private array $routes = [];

    /**
     * Callback's class and method separator
     *
     * @var string
     */
    private string $callbackSeparator;

    /**
     * Router constructor
     *
     * @param string $callbackSeparator
     */
    public function __construct(string $callbackSeparator = "@")
    {
        $this->callbackSeparator = $callbackSeparator;
    }

    /**
     * Extract class and method name from callback string info
     *
     * @param string $callback
     * @return array
     */
    public function extractCallbackInfo(string $callback): array
    {
        if (empty($callback)) {
            return [];
        }

        // Extract callback class and method with the pattern <callbackClass><separator><callbackMethod>
        [$callbackClass, $callbackMethod] = explode(
            $this->callbackSeparator,
            $callback
        );

        return [
            "callback_class" => $callbackClass,
            "callback_method" => $callbackMethod
        ];
    }

    /**
     * Add a new Route object to $routes property
     *
     * @param string $routeHttpMethod
     * @param string $routePath
     * @param string $routeController
     * @param string $routeMiddleware
     * @return void
     */
    public function addRoute(
        string $routeHttpMethod,
        string $routePath,
        string $routeController,
        string $routeMiddleware = ""
    ): void {
        // Check invalid route HTTP method
        if (
            empty($routeHttpMethod) ||
            ($routeHttpMethod !== "GET" && $routeHttpMethod !== "POST")
        ) {
            throw new RouterException("Invalid route HTTP method value. Expects GET or POST received {$routeHttpMethod}");
        }

        // Check invalid route path
        if (empty($routePath)) {
            throw new RouterException("Route path cannot be empty");
        }

        // Check invalid route controller
        if (
            empty($routeController) ||
            !str_contains($routeController, $this->callbackSeparator)
        ) {
            throw new RouterException("Invalid route controller separator");
        }

        // Check invalid route middleware
        if (!empty($routeMiddleware)) {
            if (!str_contains($routeMiddleware, $this->callbackSeparator)) {
                throw new RouterException("Invalid route middleware separator");
            }
        }

        // Extract route controller and middleware info from callback string
        $controllerInfo = $this->extractCallbackInfo($routeController);
        $middlewareInfo = $this->extractCallbackInfo($routeMiddleware);

        // Add a new Route object in the $routes array
        $this->routes[$routeHttpMethod][$routePath] = new Route(
            $routeHttpMethod,
            $routePath,
            $controllerInfo,
            $middlewareInfo
        );
    }

    /**
     * Match request URI with fixed defined routes
     *
     * @param string $requestUri
     * @param array $routes
     * @return Route|null
     */
    public function matchFixedUri(string $requestUri, array $routes): ?Route
    {
        // Check empty routes array 
        if (empty($routes)) {
            return null;
        }

        foreach ($routes as $route) {
            if ($requestUri === $route->getRoutePath()) {

                // If matched any fixed URI
                return $route;
            }
        }

        // If didn't match any fixed route
        return null;
    }

    /**
     * Match request URI with dynamic defined routes
     *
     * @param string $requestUri
     * @param array $routes
     * @return Route|null
     */
    public function matchDynamicUri(string $requestUri, array $routes): ?Route
    {
        // Check empty routes array 
        if (empty($routes)) {
            return null;
        }

        foreach ($routes as $route) {
            $pattern = str_replace("/", "\/", ltrim($route->getRoutePath(), "/"));

            // Replace alpha characters pattern
            if (str_contains($pattern, "(:alpha)")) {
                $pattern = str_replace(
                    "(:alpha)",
                    CONF_ROUTES_URI_PATTERNS["(:alpha)"],
                    $pattern
                );
            }

            // Replace numeric characters pattern
            if (str_contains($pattern, "(:numeric)")) {
                $pattern = str_replace(
                    "(:numeric)",
                    CONF_ROUTES_URI_PATTERNS["(:numeric)"],
                    $pattern
                );
            }

            // Replace alphanumeric characters pattern
            if (str_contains($pattern, "(:alphanumeric)")) {
                $pattern = str_replace(
                    "(:alphanumeric)",
                    CONF_ROUTES_URI_PATTERNS["(:alphanumeric)"],
                    $pattern
                );
            }

            // If match a dynamic URI
            if (preg_match("/^{$pattern}$/", ltrim($requestUri, "/"))) {
                return $route;
            }
        }

        // If didn't matched any dynamic URI
        return null;
    }

    /**
     * Get dynamic URI parameters
     *
     * @param string $requestUri
     * @param Route $foundRoute
     * @return array
     */
    public function getDynamicUriParameters(string $requestUri, Route $foundRoute): array
    {
        $requestUriArray = explode("/", ltrim($requestUri, "/"));
        $foundRoutePathArray = explode("/", ltrim($foundRoute->getRouteUriPath(), "/"));
        $uriArrayDiff = array_diff($requestUriArray, $foundRoutePathArray);
        $uriParams = [];

        foreach ($uriArrayDiff as $key => $value) {
            $uriParams[$requestUriArray[$key - 1]] = $value;
        }

        return $uriParams;
    }

    /**
     * Execute route middleware method
     *
     * @param Route $foundRoute
     * @return void
     */
    public function executeRouteMiddleware(Route $foundRoute): void
    {
        // Extract middleware info
        $middlewareClass = CONF_NAMESPACE_MIDDLEWARES . $foundRoute
            ->getRouteMiddleware()["callback_class"];
        $middlewareMethod = $foundRoute->getRouteMiddleware()["callback_method"];

        // Checks if middleware class exists
        if (!class_exists($middlewareClass)) {
            throw new RouterException("Route middleware class: {$middlewareClass} doesn't exists");
        }

        // Checks if middleware method exists
        if (!method_exists($middlewareClass, $middlewareMethod)) {
            throw new RouterException("Route middleware method: {$middlewareClass}@{$middlewareMethod} doesn't exists");
        }

        $newMiddleware = new $middlewareClass();

        $newMiddleware->$middlewareMethod();
    }

    /**
     * Execute route controller method
     *
     * @param Route $foundRoute
     * @param array $uriParams
     * @return void
     */
    public function executeRouteController(Route $foundRoute, array $uriParams): void
    {
        // Extract controller info
        $controllerClass = CONF_NAMESPACE_CONTROLLERS . $foundRoute
            ->getRouteController()["callback_class"];
        $controllerMethod = $foundRoute->getRouteController()["callback_method"];

        // Checks if controller class exists
        if (!class_exists($controllerClass)) {
            throw new RouterException("Route controller class: {$controllerClass} doesn't exists");
        }

        // Checks if controller class method exists 
        if (!method_exists($controllerClass, $controllerMethod)) {
            throw new RouterException("Route controller method: {$controllerClass}@{$controllerMethod} doesn't exists");
        }

        $newController = new $controllerClass();

        // Execute route middleware if there is one
        if (!empty($foundRoute->getRouteMiddleware())) {
            $this->executeRouteMiddleware($foundRoute);
        }

        $newController->$controllerMethod($uriParams);
    }

    /**
     * Handles requested URI
     *
     * @param string $requestMethod
     * @param string $requestUri
     * @return void
     */
    public function handleRequest(string $requestMethod, string $requestUri): void
    {
        // Check invalid request HTTP method
        if (($requestMethod !== "GET" && $requestMethod !== "POST")) {
            throw new RouterException("Invalid route HTTP method value. Expect GET or POST received {$requestMethod}");
        }

        $foundRoute = $this->matchFixedUri($requestUri, $this->routes[$requestMethod]);
        $uriParams = [];

        // Didn't match any fixed URI (null returned)
        if (!$foundRoute) {
            $foundRoute = $this->matchDynamicUri(
                $requestUri,
                $this->routes[$requestMethod]
            );

            // Found a dynamic URI and get it's parameters
            if ($foundRoute) {
                $uriParams = $this->getDynamicUriParameters(
                    $requestUri,
                    $foundRoute
                );
            }
        }

        // If didn't match any URI
        if (!$foundRoute) {
            throw new RouterException("Route {$requestUri} not found");
        }

        $this->executeRouteController($foundRoute, $uriParams);
    }

    /**
     * Get defined routes 
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Get callback string separator
     *
     * @return string
     */
    public function getCallbackSeparator(): string
    {
        return $this->callbackSeparator;
    }
}
