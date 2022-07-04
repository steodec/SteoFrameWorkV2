<?php

namespace Steodec\SteoFrameWork\Test;

use PHPUnit\Framework\TestCase;
use ReflectionException;
use Steodec\SteoFrameWork\Orm\ORMException;

class ORMMainTest extends TestCase {
    /**
     * @throws ReflectionException|ORMException
     */
    public function testCreate() {
        $entity       = new TestEntity();
        $entity->name = "Hello World";
        $result       = $entity->create();
        $this->assertEquals($result->name, "Hello World");
    }

    public function testReadAll() {
        $entity = new TestEntity();
        $result = $entity->readAll();
        $this->assertNotEmpty($result);
    }

    public function testReadByID() {
        $entity     = new TestEntity();
        $result     = $entity->readAll();
        $id         = $result[0]->id;
        $entity->id = $id;
        $result     = $entity->readByID();
        $this->assertEquals($result->id, $id);
    }

    public function testUpdate() {
        $entity       = new TestEntity();
        $result       = $entity->readAll();
        $id           = $result[0]->id;
        $entity->id   = $id;
        $entity->name = "New Name";
        $result       = $entity->update();
        $this->assertEquals($result->name, "New Name");
    }


    public function testDelete() {
        $entity     = new TestEntity();
        $result     = $entity->readAll();
        $id         = $result[0]->id;
        $entity->id = $id;
        $result     = $entity->delete();
        $this->assertTrue($result);
    }
}
