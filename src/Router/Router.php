<?php

namespace Steodec\SteoFrameWork\Router;

use AltoRouter;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    private AltoRouter $router;

    public function __construct()
    {
        $this->router = new AltoRouter();
    }

    /**
     * @param string      $method
     * @param string      $path
     * @param callable    $callback
     * @param string|null $name
     *
     * @return void
     * @throws \Exception
     */
    public function add(string $method, string $path, callable $callback, string $name = null)
    {
        $this->router->map($method, $path, $callback, $name);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Steodec\SteoFrameWork\Router\Route|null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $route = $this->router->match($request->getUri()->getPath(), $request->getMethod());
        return ($route) ? new Route($route['name'], $route['target'], $route['params']) : null;
    }

    /**
     * @param string $name
     * @param array  $params
     * @param array  $queryParams
     *
     * @return string
     * @throws \Exception
     */
    public function generateUri(string $name, array $params = [], array $queryParams = [])
    {
        $uri = $this->router->generate($name, $params);
        if (!empty($queryParams)) {
            return $uri . '?' . http_build_query($queryParams);
        }
        return $uri;
    }
}
