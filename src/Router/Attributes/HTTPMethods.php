<?php

namespace Steodec\SteoFrameWork\Router\Attributes;

enum HTTPMethods: string
{
    case GET    = 'GET';
    case POST   = 'POST';
    case PUT    = 'PUT';
    case DELETE = 'DELETE';
}//end enum
