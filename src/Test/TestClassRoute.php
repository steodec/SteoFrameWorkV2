<?php

namespace Steodec\SteoFrameWork\Test;

use Steodec\SteoFrameWork\Router\Attributes\Get;

class TestClassRoute
{

    #[Get]
    public function index(): void
    {
        var_dump('Toto');
    }

    #[Get(_name: 'TEST_CREATE')]
    public function create(): void
    {
    }
}
