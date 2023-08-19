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
     * Route HTTP method (GET, POST, PUT, PATCH, DELETE)
     *
     * @var string
     */
    private string $routeHttpMethod;

    /**
     * Route URI path
     *
     * @var string
     */
    private string $routeUriPath;

    /**
     * Undocumented variable
     *
     * @var array
     */
    private array $routeController;

    /**
     * Route middleware (optional)
     *
     * @var array|null
     */
    private ?array $routeMiddleware;

    /**
     * Route constructor
     *
     * @param string $routeHttpMethod
     * @param array $routeController
     * @param array|null $routeMiddleware
     */
    public function __construct(
        string $routeHttpMethod,
        string $routeUriPath,
        array $routeController,
        ?array $routeMiddleware = null
    ) {
        $this->routeHttpMethod = mb_strtoupper($routeHttpMethod);
        $this->routeUriPath = $routeUriPath;
        $this->routeController = $routeController;
        $this->routeMiddleware = $routeMiddleware;
    }

    /**
     * Get route HTTP method property value
     *
     * @return string
     */
    public function getRouteHttpMethod(): string 
    {
        return $this->routeHttpMethod;
    }

    /**
     * Get route URI path property value
     *
     * @return string
     */
    public function getRouteUriPath(): string 
    {
        return $this->routeUriPath;
    }

    /**
     * Get route controller property value
     *
     * @return array
     */
    public function getRouteController(): array 
    {
        return $this->routeController;
    }

    /**
     * Get route middleware property value
     *
     * @return array|null
     */
    public function getRouteMiddleware(): ?array 
    {
        return $this->routeMiddleware;
    }
}
