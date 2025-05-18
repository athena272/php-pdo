<?php

try {
    $pdo = new PDO('sqlite:database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Successfully connected to the SQLite database.";
} catch (PDOException $e) {
    echo "❌ Failed to connect to the SQLite database: " . $e->getMessage();
}
