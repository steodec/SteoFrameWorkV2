<?php

namespace Steodec\SteoFrameWork\Test;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Steodec\SteoFrameWork\Routers\Attributes\HTTPMethods;
use Steodec\SteoFrameWork\Routers\Main;

class RouteMainTest extends TestCase {

    /**
     * @throws ReflectionException
     */
    public function testGetRoute() {
        $main   = new Main("Steodec\\SteoFrameWork\\Test");
        $routes = $main->getRoute();
        $this->assertNotEmpty($routes);

    }

    /**
     * @throws ReflectionException
     */
    public function testCheckRoute() {
        $main   = new Main("Steodec\\SteoFrameWork\\Test");
        $routes = $main->getRoute()[1];
        $this->assertEquals(HTTPMethods::GET->value, $routes->getMethod());

    }

    /**
     * @throws ReflectionException
     */
    public function testCheckName() {
        $main   = new Main("Steodec\\SteoFrameWork\\Test");
        $routes = $main->getRoute()[1];
        $this->assertEquals('TEST_CREATE', $routes->getName());
    }
}
