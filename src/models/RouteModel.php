<?php

declare(strict_types=1);

namespace src\models;

/**
 * Class RouteModel 
 * 
 * @package src\models
 */
final class RouteModel
{
    /**
     * RouteModel constructor
     *
     * @param string $routeHttpMethod
     * @param string $routePath
     * @param array $routeController
     * @param array $routeMiddleware
     */
    public function __construct(
        private string $routeHttpMethod,
        private string $routePath,
        private array $routeController,
        private ?array $routeMiddleware = null,
    ) {
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
