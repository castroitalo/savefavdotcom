<?php

declare(strict_types=1);

namespace src\models;

/**
 * Class Route 
 * 
 * @package src\models
 */
final class Route
{
    /**
     * Route HTTP method (GET/POST)
     *
     * @var string
     */
    private string $routeHttpMethod;

    /**
     * Route Path
     *
     * @var string
     */
    private string $routePath;

    /**
     * Route controller, an array that contais the controller class and method
     *
     * @var array
     */
    private array $routeController;

    /**
     * Route middleware, an array that contains the middleware class and method
     *
     * @var array|null
     */
    private ?array $routeMiddleware;

    /**
     * Route constructor
     *
     * @param string $routeHttpMethod
     * @param string $routePath
     * @param string $routeController
     * @param array $routeMiddleware
     */
    public function __construct(
        string $routeHttpMethod,
        string $routePath,
        array $routeController,
        ?array $routeMiddleware = null,
    ) {
        $this->routeHttpMethod = strtoupper($routeHttpMethod);
        $this->routePath = $routePath;
        $this->routeController = $routeController;
        $this->routeMiddleware = $routeMiddleware;
    }

    /**
     * Get route HTTP method
     *
     * @return string
     */
    public function getRouteHttpMethod(): string 
    {
        return $this->routeHttpMethod;
    }

    /**
     * Get route Path
     *
     * @return string
     */
    public function getRoutePath(): string 
    {
        return $this->routePath;
    }

    /**
     * Get route controller
     *
     * @return array
     */
    public function getRouteController(): array 
    {
        return $this->routeController;
    }

    /**
     * Get route middleware
     *
     * @return array|null
     */
    public function getRouteMiddleware(): ?array 
    {
        return $this->routeMiddleware;
    }
}
