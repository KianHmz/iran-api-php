<?php

namespace App\Core;

/**
 * Database connection handler using PDO
 * 
 * This class provides a singleton pattern implementation for database connections
 * using PDO. It ensures only one database connection is maintained throughout
 * the application lifecycle.
 */
class Database
{
    /**
     * @var \PDO|null Static instance of PDO connection
     */
    private static $pdo = null;

    /**
     * Establishes a database connection 
     * 
     * @return \PDO Returns the PDO database connection instance
     * @throws \PDOException If connection fails
     */
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
