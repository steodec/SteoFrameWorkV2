<?php

namespace Steodec\SteoFrameWork\Routers;

use Exception;
use HaydenPierce\ClassFinder\ClassFinder;
use ReflectionClass;
use ReflectionException;
use Steodec\SteoFrameWork\Routers\Attributes\HTTPMethods;
use Steodec\SteoFrameWork\Routers\Attributes\RouteAttribute;

class Main {
    /**
     * @var string
     */
    private string $namespace;
    /**
     * @var callable|null
     */
    private mixed $middleware;

    /**
     * @param string $namespace
     * @param callable|null $middleware
     */
    public function __construct(string $namespace, callable|null $middleware = NULL) {
        $this->namespace  = $namespace;
        $this->middleware = $middleware;
    }

    /**
     * @throws RouterException
     * @throws ReflectionException
     */
    public function run(): void {
        $routes = $this->getRoute();
        $router = new Router($_GET['url']);
        foreach ($routes as $route):
            $router->add($route->getPath(), $route->getCallable(), $route->getName(), $route->getMethod());
        endforeach;
        $router->run();
    }

    /**
     * @throws ReflectionException
     */
    private function registerController(string $controller): array {
        $class      = new ReflectionClass($controller);
        $routeArray = [];
        foreach ($class->getMethods() as $method) {
            $router = $method->getAttributes(RouteAttribute::class, \ReflectionAttribute::IS_INSTANCEOF);
            if (empty($router)) continue;
            foreach ($router as $r) {
                $newRoute = $r->newInstance();
                if ($newRoute instanceof RouteAttribute):
                    $array       = explode('\\', strtolower($method->class));
                    $class       = end($array);
                    $method_name = strtolower($method->name);
                    if (empty($newRoute->getPath())) $newRoute->setPath("/{$class}/{$method_name}");
                    if ($method_name == 'index')
                        $newRoute->setPath("/{$class}/");
                    if (empty($newRoute->getMethod())) $newRoute->setMethod(HTTPMethods::GET);
                    $newRoute->setCallable($method->class . "#" . $method->name);
                    $routeArray[] = $newRoute;
                endif;
            }
        }
        return $routeArray;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function getRoute(): array {
        $classes = ClassFinder::getClassesInNamespace($this->namespace, ClassFinder::RECURSIVE_MODE);
        $routes  = [];
        foreach ($classes as $class) {
            $routes = array_merge($routes, self::registerController($class));
        }
        foreach ($routes as $routeArray):
            foreach ($routeArray as $key => $route):
                if (!empty($route->getIsGranted())):
                    if ($this->middleware != NULL or !$this->{"middleware"}($route))
                        unset($routes[$key]);
                endif;
            endforeach;
        endforeach;
        return $routes;
    }

}