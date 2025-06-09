<?php

namespace Athena272\Pdo\Infrastructure\Persistence;

use PDO;
use PDOException;

class ConnectionCreator
{
    public static function createConnection(): PDO
    {
        $databasePath = __DIR__ . DIRECTORY_SEPARATOR . '../../../database.sqlite';

        try {
            $pdo = new PDO("sqlite:$databasePath");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            echo "✅ Successfully connected to the SQLite database." . PHP_EOL;
            return $pdo;
        } catch (PDOException $e) {
            echo "❌ Failed to connect to the SQLite database: " . $e->getMessage();
            exit();
        }
    }
}