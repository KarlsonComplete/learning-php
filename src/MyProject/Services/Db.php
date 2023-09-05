<?php

namespace Myproject\Services;

class Db
{
    private $pdo;

    public function __construct()
    {
        $dbPathOptions  = (require __DIR__ . '/../../settings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbPathOptions['host'], $dbPathOptions['user'], $dbPathOptions['password'], $dbPathOptions['dbname']
        );
        $this->pdo->exec('SET NAMES UTF8');

    }
}