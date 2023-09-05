<?php

namespace Myproject\Services;

class Db
{
    private $pdo;

    public function __construct()
    {
        $dbPathOptions  = (require __DIR__ . '/../../settings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host='. $dbPathOptions['host'] . ';dbname=' . $dbPathOptions['dbname'],
            $dbPathOptions['user'],
            $dbPathOptions['password']
        );
        $this->pdo->exec('SET NAMES UTF8');
    }

    public function query(string $sql, $params = []): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result)
        {
            return null;
        }
        return $sth->fetchAll();
    }
}