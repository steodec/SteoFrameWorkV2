<?php

namespace Steodec\SteoFrameWork\ORM;

use phpDocumentor\Reflection\Types\This;
use ReflectionException;

abstract class AbstractEntities
{
    public const TABLE_NAME = "";

    public int|null $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    use ORM;
}//end class
