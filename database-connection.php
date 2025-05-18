<?php

$databasePath = __DIR__ . DIRECTORY_SEPARATOR . 'database.sqlite';

try {
    $pdo = new PDO("sqlite:$databasePath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Successfully connected to the SQLite database.";
} catch (PDOException $e) {
    echo "❌ Failed to connect to the SQLite database: " . $e->getMessage();
    exit();
}

$pdo->exec('CREATE TABLE students (id INTEGER PRIMARY KEY, name TEXT, birth_date TEXT);');