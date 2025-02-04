<?php

namespace Alison\TaskManagementSystem\Service;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        $dsn = 'pgsql:host=localhost;port=5432;dbname=task_managment_system';
        $username = 'postgres';
        $password = '';

        if (self::$connection === null) {
            try {
                self::$connection = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                echo 'Підключення не вдалося: ' . $e->getMessage();
                exit;
            }
        }
        return self::$connection;
    }
}