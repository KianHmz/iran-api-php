<?php

namespace App\Core;

class Database extends \PDO
{
    public function __construct($host, $dbname, $username, $password, $charset = 'utf8mb4')
    {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        try {
            parent::__construct($dsn, $username, $password);
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception('ERROR db connection: ' . $e->getMessage());
        }
    }
}
