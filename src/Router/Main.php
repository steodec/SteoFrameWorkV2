<?php

namespace Steodec\SteoFrameWork\Router;

use Exception;
use HaydenPierce\ClassFinder\ClassFinder;
use ReflectionClass;
use ReflectionException;
use Steodec\SteoFrameWork\Router\Attributes\HTTPMethods;
use Steodec\SteoFrameWork\Router\Attributes\RouteAttribute;

class Main
{
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
    public function __construct(string $namespace, ?callable $middleware = null)
    {
        $this->namespace  = $namespace;
        $this->middleware = $middleware;
    }

    /**
     * @throws ReflectionException
     */
    private function registerController(string $controller): array
    {
        $class      = new ReflectionClass($controller);
        $routeArray = [];
        foreach ($class->getMethods() as $method) {
            $router = $method->getAttributes(RouteAttribute::class, \ReflectionAttribute::IS_INSTANCEOF);
            if (empty($router)) {
                continue;
            }
            foreach ($router as $r) {
                $newRoute = $r->newInstance();
                if ($newRoute instanceof RouteAttribute) :
                    $array       = explode('\\', strtolower($method->class));
                    $class       = end($array);
                    $method_name = strtolower($method->name);
                    if ($method_name == 'index' && empty($newRoute->getPath())) {
                        $newRoute->setPath("/{$class}/");
                    }
                    if (empty($newRoute->getPath())) {
                        $newRoute->setPath("/{$class}/{$method_name}");
                    }
                    if (empty($newRoute->getMethod())) {
                        $newRoute->setMethod(HTTPMethods::GET);
                    }
                    $newRoute->setCallable($method->class . "#" . $method->name);
                    $routeArray[] = $newRoute;
                endif;
            }
        }
        return $routeArray;
    }
}
