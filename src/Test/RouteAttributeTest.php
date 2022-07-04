<?php

namespace Steodec\SteoFrameWork\Test;

use PHPUnit\Framework\TestCase;
use Steodec\SteoFrameWork\Routers\Attributes\Get;
use Steodec\SteoFrameWork\Routers\Attributes\HTTPMethods;

class RouteAttributeTest extends TestCase {

    public function testCreate() {
        $attribute = new Get();
        $this->assertEquals(HTTPMethods::GET->value, $attribute->getMethod());
    }

}
