<?php

namespace Myproject\Services;


use Myproject\Exception\DbException;
use PDO;

class Db
{
    private PDO $pdo;

    private static $instance;

    private function __construct()
    {
        $dbPathOptions  = (require __DIR__ . '/../../settings.php')['db'];
        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $dbPathOptions['host'] . ';dbname=' . $dbPathOptions['dbname'],
                $dbPathOptions['user'],
                $dbPathOptions['password']
            );
            $this->pdo->exec('SET NAMES UTF8');
        } catch (\PDOException $e) {
            throw new DbException('Ошибка при подключении к базе данных: ' . $e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query(string $sql, $params = [], string $className = 'stdClass'): ?array
    {
        // Функция prepare подготавливает запрос к выполнению и возвращает связанный с этим запросом объект
        $sth = $this->pdo->prepare($sql);
        //Функция execute запускает подготовленный запрос на выполнение
        $result = $sth->execute($params);

        if (false === $result)
        {
            return null;
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function lastInsertId(string $sql): string|false
    {
        $lastId = $this->pdo->lastInsertId($sql);

        if (false === $lastId)
        {
            return false;
        }

        return $lastId;
    }


}