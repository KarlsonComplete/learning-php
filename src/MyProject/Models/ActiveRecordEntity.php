<?php

namespace Myproject\Models;

use Myproject\Services\Db;

abstract class ActiveRecordEntity
{
    protected int $id;

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

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
       $entities =  $db->query(
            'SELECT * FROM`' . static::getTableName() .'` WHERE id = :id;',
            [':id' => $id],
           static::class
        );
       return $entities ? $entities[0] : null;
    }

    private function underscoreToCamelCase(string $name): string
    {
        $str = str_replace('_', '', ucwords($name,'_'));
        $str = lcfirst($str);
        return $str;
    }

   abstract protected static function getTableName(): string;

}