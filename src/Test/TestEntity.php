<?php

namespace Steodec\SteoFrameWork\Test;

use Steodec\SteoFrameWork\Orm\AbstractEntities;

class TestEntity extends AbstractEntities
{

    const TABLE_NAME = "test";
    public string $name;
}
