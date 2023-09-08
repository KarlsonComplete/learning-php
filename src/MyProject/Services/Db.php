<?php

namespace Myproject\Services;
use PDO;

class Db
{
    private PDO $pdo;

    private static $instance;

    private function __construct()
    {

        $dbPathOptions  = (require __DIR__ . '/../../settings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host='. $dbPathOptions['host'] . ';dbname=' . $dbPathOptions['dbname'],
            $dbPathOptions['user'],
            $dbPathOptions['password']
        );
        $this->pdo->exec('SET NAMES UTF8');
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
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result)
        {
            return null;
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }
}