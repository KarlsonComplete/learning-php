<?php

namespace Myproject\Models;

use MyProject\Models\Articles\Article;
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
        var_dump($sql);
        return Db::getInstance()->query(
            $sql, $params2values, static::class
        );
    }

    private function insert(array $mappedProperties): string|bool
    {
        $params = [];
        $params2values = [];
        $columns = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $columns[] = $column;
            $param = ':param' . $index;
            $params[] = $param; // param1
            $params2values[$param] = $value; // [param1 => value1]
            $index++;
        }

        $sql = 'INSERT INTO ' . static::getTableName() . '(' . implode(' , ', $columns) . ') VALUES(' . implode(' , ', $params) . ')';
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
        return $db->lastInsertId($sql);

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