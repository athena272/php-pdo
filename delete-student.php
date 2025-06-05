<?php

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . DIRECTORY_SEPARATOR . 'database.sqlite';

try {
    $pdo = new PDO("sqlite:$databasePath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Successfully connected to the SQLite database." . PHP_EOL;
} catch (PDOException $e) {
    echo "❌ Failed to connect to the SQLite database: " . $e->getMessage();
    exit();
}

$sqlDelete = "DELETE FROM students WHERE id = :id";
$preparedStatement = $pdo->prepare($sqlDelete);
$preparedStatement->bindValue(':id', 2, PDO::PARAM_INT);

if ($preparedStatement->execute()) {
    echo "Student deleted successfully." . PHP_EOL;
}