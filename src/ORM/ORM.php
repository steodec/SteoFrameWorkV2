<?php

namespace Steodec\SteoFrameWork\ORM;

use PDO;
use ReflectionClass;
use ReflectionException;

class ORM {

    protected static ORM|null $_instance = NULL;
    private PDO               $connection;

    private function __construct() {
        $this->connection = Connection::getInstance();
    }

    public static function getInstance(): ORM {
        return (is_null(self::$_instance)) ? new ORM() : self::$_instance;
    }

    /**
     * Return all entries of object in database
     * @param AbstractEntities $entity
     * @return AbstractEntities[]
     * @throws ORMException
     */
    public function readAll(AbstractEntities $entity): iterable {
        $query = sprintf("SELECT * FROM %s;", $entity::TABLE_NAME);

        $sql = $this->connection->query($query);
        $sql->execute();
        $result = $sql->fetchAll($this->connection::FETCH_CLASS, $entity::class);
        if ($result > 0):
            return $result;
        else: return throw new ORMException("N/A");
        endif;
    }

    /**
     * Return entry by id of object in database
     * @param AbstractEntities|null $entity
     * @param string|null $tableName
     * @param mixed $id
     * @param string|null $className
     * @return AbstractEntities
     * @throws ORMException
     */
    public function readByID(AbstractEntities $entity = NULL, string $tableName = NULL, mixed $id = NULL, string $className = NULL): AbstractEntities {
        if ($entity):
            $query = sprintf("SELECT * FROM %s WHERE id='%s';", $entity::TABLE_NAME, $entity->id);
        else:
            $query = sprintf("SELECT * FROM %s WHERE id='%s';", $tableName, $id);
        endif;
        $sql = $this->connection->query($query);
        $sql->execute();
        $result = $sql->fetchAll($this->connection::FETCH_CLASS, (is_null($entity)) ? $className : $entity::class);
        if ($result > 0):
            return $result[0];
        else: return throw new ORMException("N/A");
        endif;
    }

    /**
     * Create row in database
     * @param AbstractEntities $entity
     * @return AbstractEntities
     * @throws ReflectionException
     * @throws ORMException
     */
    public function create(AbstractEntities $entity): AbstractEntities {
        $reflect      = new ReflectionClass($entity);
        $fields       = [];
        $values       = [];
        $valuesFields = [];
        foreach ($reflect->getProperties(\ReflectionProperty::IS_PUBLIC) as $field):
            if ($reflect->getProperty($field->name)->isInitialized($entity)):
                $fields[]       = $field->name;
                $values[]       = $reflect->getProperty($field->name)->getValue($entity);
                $valuesFields[] = '?';
            endif;
        endforeach;
        $query = sprintf("INSERT INTO %s (%s) VALUES (%s)", $entity::TABLE_NAME, implode(',', $fields), implode(',', $valuesFields));

        $sql = $this->connection->prepare($query);
        $sql->execute($values);
        $id = $this->connection->lastInsertId($entity::TABLE_NAME);
        return ($this->readByID(tableName: $entity::TABLE_NAME, id: $id, className: $entity::class));
    }

    /**
     * Update row in database
     * @param AbstractEntities $entity
     * @return AbstractEntities
     * @throws ReflectionException|ORMException
     */
    public function update(AbstractEntities $entity): AbstractEntities {
        $reflect = new ReflectionClass($entity);
        $fields  = [];
        $values  = [];
        foreach ($reflect->getProperties(\ReflectionProperty::IS_PUBLIC) as $field):
            if ($reflect->getProperty($field->name)->isInitialized($entity)):
                $fields[] = $field->name . '= ?';
                $values[] = $reflect->getProperty($field->name)->getValue($entity);
            endif;
        endforeach;
        $query = sprintf("UPDATE %s SET %s WHERE id='%s'", $entity::TABLE_NAME, implode(',', $fields), $entity->id);

        $sql = $this->connection->prepare($query);
        $sql->execute($values);
        return ($this->readByID(tableName: $entity::TABLE_NAME, id: $entity->id, className: $entity::class));
    }

    /**
     * Delete row in database
     * @param AbstractEntities $entity
     * @return bool
     */
    public function delete(AbstractEntities $entity): bool {
        $query = sprintf("DELETE FROM %s WHERE id='%s'", $entity::TABLE_NAME, $entity->id);

        $sql = $this->connection->prepare($query);
        return ($sql->execute());
    }

    /**
     * Return count of entries in database
     * @param AbstractEntities $entity
     * @return int
     * @throws ORMException
     */
    public function count(AbstractEntities $entity): int {
        $query = sprintf("SELECT count(*) as count FROM %s;", $entity::TABLE_NAME);

        $sql = $this->connection->query($query);
        $sql->execute();
        $result = $sql->fetchAll($this->connection::FETCH_CLASS, $entity::class);
        if ($result > 0):
            return $result[0]->count;
        else: return throw new ORMException("N/A");
        endif;
    }
}