<?php

namespace App\Core;

class Database
{
    private static $pdo = null;

    public static function connect()
    {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            try {
                self::$pdo = new \PDO($dsn, DB_USERNAME, DB_PASSWORD);
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                die('ERROR: DB Connection failed: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
