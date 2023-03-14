<?php

namespace Steodec\SteoFrameWork\Router\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Route extends RouteAttribute
{
    public function __construct(
        HTTPMethods $_method,
        bool|string $_path = false,
        bool|string $_name = false,
        bool|string $_isGranted = false
    ) {
        parent::__construct($_method, $_path, $_name, $_isGranted);
    }
}
