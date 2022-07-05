<?php

namespace Steodec\SteoFrameWork\ORM;

use ReflectionException;

abstract class AbstractEntities {
    /**
     * @const string TABLE_NAME
     */
    public const TABLE_NAME = "";

    /**
     * @var mixed
     */
    public mixed $id;

    /**
     * @return mixed
     */
    public function getId(): mixed {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(mixed $id): void {
        $this->id = $id;
    }

    /**
     * @return AbstractEntities
     * @throws ORMException|ReflectionException
     */
    public function create(): self {
        return ORM::getInstance()->create($this);
    }

    /**
     * @return AbstractEntities[]
     * @throws ORMException
     */
    public function readAll(): iterable {
        return ORM::getInstance()->readAll($this);
    }

    /**
     * @return AbstractEntities
     * @throws ORMException+
     */
    public function readByID(): self {
        return ORM::getInstance()->readByID($this);
    }

    /**
     * @return AbstractEntities
     * @throws ORMException
     * @throws ReflectionException
     */
    public function update(): AbstractEntities {
        return ORM::getInstance()->update($this);
    }

    /**
     * @return bool
     */
    public function delete(): bool {
        return ORM::getInstance()->delete($this);
    }

    /**
     * @return int
     * @throws ORMException
     */
    public function count(): int {
        return ORM::getInstance()->count($this);
    }

}