<?php

namespace Myproject\Models;

use Myproject\Services\Db;

abstract class ActiveRecordEntity
{
    protected ?int $id = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    public static function findOneByColumn(string $columnName, $value): ?self
    {
        var_dump($columnName);
        var_dump($value);
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` =:value LIMIT 1;',
            [':value' => $value],
            static::class
        );
    var_dump($result);
        if ($result === [])
        {
            return null;
        }

        return $result[0];
    }

    public function save(): bool|string|array
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if($this->id !== null) {
          return $this->update($mappedProperties);
        }

        return  $this->insert($mappedProperties);
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $mappedProperties = [];

        foreach ($properties as $property) {
            $propertyName = $property->name;
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM`' . static::getTableName() . '` WHERE id = :id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public static function getArrayById(int $id, string $column): ?array
    {

        $column_string = $column . '=' . ':' . $column . ';';
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM`' . static::getTableName() . '` WHERE ' . $column_string,
            [':'.$column => $id],
            static::class
        );
        return $entities ?: null;
    }

    public function drop(): void
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'DELETE FROM`' . static::getTableName() . '` WHERE id = :id;',
            [':id' => $this->id],
            static::class
        );
        $this->id = null;
    }

    private function update(array $mappedProperties): ?array
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index;
            $columns2params[] = $column . ' = ' . $param; // column1 = param1
            $params2values[$param] = $value; // [param1 => value1]
            $index++;
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;
        return Db::getInstance()->query(
            $sql, $params2values, static::class
        );
    }

    private function insert(array $mappedProperties): string|bool
    {
        $filteredProperties = array_filter($mappedProperties);

        $params = [];
        $params2values = [];
        $columns = [];
        $index = 1;
        foreach ($filteredProperties as $column => $value) {
            $columns[] = $column;
            $param = ':param' . $index;
            $params[] = $param; // param1
            $params2values[$param] = $value; // [param1 => value1]
            $index++;
        }

        $sql = 'INSERT INTO ' . static::getTableName() . '(' . implode(' , ', $columns) . ') VALUES(' . implode(' , ', $params) . ')';
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
        $this->id = $db->lastInsertId($sql);
        $this->refresh();
        return  $this->id;
    }

    private function refresh(): void
    {
        $objectFromDb = static::getById($this->id);
        $reflector = new \ReflectionObject($objectFromDb);
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $this->$propertyName = $property->getValue($objectFromDb);
        }
    }

    private function underscoreToCamelCase(string $name): string
    {
        $str = str_replace('_', '', ucwords($name, '_'));
        $str = lcfirst($str);
        return $str;
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    abstract protected static function getTableName(): string;

}