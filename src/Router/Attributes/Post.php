<?php

namespace Steodec\SteoFrameWork\Router\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Post extends RouteAttribute
{


    public function __construct(bool|string $_path = false, bool|string $_name = false, bool|string $_isGranted = false)
    {
        parent::__construct(HTTPMethods::POST, $_path, $_name, $_isGranted);
    }//end __construct()
}//end class
