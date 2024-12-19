<?php

namespace Core;

use Exception;

class Router
{
    /**
     * All registered routes.
     *
     * @var array
     */
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Load a user's routes file.
     *
     * @param string $file
     */
    public static function load(string $file): Router
    {
        $router = new static;

        require $file;

        return $router;
    }

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function get(string $uri, string $controller): Router
    {
        $this->routes['GET'][$uri] = $controller;

        return $this;
    }

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function post(string $uri, string $controller): Router
    {
        $this->routes['POST'][$uri] = $controller;

        return $this;
    }

    /**
     * Load the requested URI's associated controller method.
     *
     * @param string $uri
     * @param string $requestType
     */
    public function direct(string $uri, string $requestType): mixed
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        abort();
    }

    /**
     * Load and call the relevant controller action.
     *
     * @param string $controller
     * @param string $action
     */
    protected function callAction(string $controller, string $action): mixed
    {
        $controller = "Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controller->$action();
    }
}
