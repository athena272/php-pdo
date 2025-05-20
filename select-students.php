<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Domain\Models\Student;

$databasePath = __DIR__ . DIRECTORY_SEPARATOR . 'database.sqlite';

try {
    $pdo = new PDO("sqlite:$databasePath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Successfully connected to the SQLite database.";
} catch (PDOException $e) {
    echo "❌ Failed to connect to the SQLite database: " . $e->getMessage();
    exit();
}

$sqlSelect = "SELECT * FROM students";

$result = $pdo->query($sqlSelect);