<?php

namespace Steodec\SteoFrameWork\ORM;

use PDO;
use ReflectionClass;
use ReflectionException;

trait ORM
{

    private PDO $PDO;
    private string $query = "";
    private array $values = [];


    private function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }//end __construct()

    /**
     * Start query with select
     *
     * @return self
     */
    public function select(): self
    {
        $this->query .= "SELECT";
        return $this;
    }

    /**
     * Add select fields
     *
     * @param string $fields
     *
     * @return self
     */
    public function addFields(string $fields): self
    {
        if (str_ends_with($this->query, "SELECT")) :
            $this->query .= " " . $fields;
        else :
            $this->query .= ", " . $fields;
        endif;
        return $this;
    }

    /**
     * Add where case
     *
     * @param string       $property
     * @param OperatorEnum $operatorEnum
     * @param mixed        $value
     * @param string       $operator
     *
     * @return self
     */
    public function addWhereCase(string $property, OperatorEnum $operatorEnum, mixed $value, string $operator = "AND"): self
    {
        if (!str_contains($this->query, 'FROM')) :
            $this->query .= sprintf(" FROM %s", $this::TABLE_NAME);
        endif;
        if (str_ends_with($this->query, $this::TABLE_NAME)) :
            $this->query .= sprintf(" WHERE %s%s:%s", $property, $operatorEnum->value, $property);
        else :
            $this->query .= sprintf(" %s %s%s:%s", $operator, $property, $operatorEnum->value, $property);
        endif;
        $this->values[$property] = $value;
        return $this;
    }

    /**
     * Add Order by case in query select
     *
     * @param string $property
     * @param string $descOrAsc
     *
     * @return self
     */
    public function addOrderBy(string $property, string $descOrAsc = "ASC"): self
    {
        $this->query = sprintf(" ORDER BY %s %s", $property, $descOrAsc);
        return $this;
    }

    /**
     * Add Limit in query select
     *
     * @param int $limit
     *
     * @return self
     */
    public function addLimit(int $limit): self
    {
        $this->query = " LIMIT " . $limit;
        return $this;
    }

    /**
     * Execute select query
     *
     * @param string|null $query
     *
     * @return self
     * @throws ORMException
     */
    public function execute(string $query = null): iterable|AbstractEntities
    {
        if (is_null($query)) :
            $queryPDO = $this->PDO->prepare($this->query);
            foreach ($this->values as $key => $value) :
                $queryPDO->bindParam(":$key", $value, $this->getType($value));
            endforeach;
        else :
            $queryPDO = $this->PDO->query($query);
        endif;
        $result = $queryPDO->execute();
        if (!$result) :
            throw new ORMException("Une erreur c'est produite");
        endif;
        $return = $query->fetchAll(PDO::FETCH_CLASS, $this::class);

        return (count($return) > 1) ? $return : $return[0];
    }

    /**
     * Save entity in database insert or update
     *
     * @return self
     * @throws ReflectionException
     * @throws ORMException
     */
    public function save(): self
    {
        $query = "";
        if (is_null($this->getId())) :
            $query = sprintf("INSERT INTO %s", $this::TABLE_NAME);
        else :
            $query = sprintf("UPDATE %s", $this::TABLE_NAME);
        endif;
        $reflectionClass = new ReflectionClass($this);
        $properties = [];
        foreach ($reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $property) :
            if (!$property->isInitialized($this)) {
                continue;
            }
            $properties[$property->getName()] = $property->getValue($this);
        endforeach;
        $query .= $this->formatSet($properties);
        $queryPdo = $this->PDO->prepare($query);
        foreach ($properties as $key => $property) :
            $queryPdo->bindParam(":$key", $property, $this->getType($property));
        endforeach;
        $execute = $queryPdo->execute();
        if (!$execute) :
            throw new ORMException("Une erreur c'est produite lors de l'execution");
        endif;
        if (is_null($this->getId())) :
            $this->id = $this->PDO->lastInsertId($this::TABLE_NAME);
        endif;
        $result = $this->select()
                       ->addWhereCase('id', OperatorEnum::EQUAL, $this->getId())
                       ->addLimit(1)
                       ->execute();
        return $result;
    }

    /**
     * Return set input like SET key1=:key1, key2=:key2
     *
     * @param array $properties
     *
     * @return string
     */
    private function formatSet(array $properties): string
    {
        $set = "";
        foreach ($properties as $key => $property) :
            if (array_key_first($properties, $key)) :
                $set .= "SET";
            endif;
            $set .= " $key = :$key";
            if (!array_key_last($properties, $key)) :
                $set .= ",";
            endif;
        endforeach;
        return $set;
    }

    /**
     * Return PDO type for bindParam
     *
     * @param mixed $value
     *
     * @return int
     * @throws \Exception
     */
    private function getType(mixed $value)
    {
        return match (gettype($value)) {
            "boolean" => PDO::PARAM_BOOL,
            "double", "integer" => PDO::PARAM_INT,
            "array", "object", "string" => PDO::PARAM_STR,
            'NULL' => PDO::PARAM_NULL,
            default => throw new \Exception('Unexpected value'),
        };
    }
}
