<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Domain\Models\Student;

$databasePath = __DIR__ . DIRECTORY_SEPARATOR . 'database.sqlite';

try {
    $pdo = new PDO("sqlite:$databasePath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Successfully connected to the SQLite database." . PHP_EOL;
} catch (PDOException $e) {
    echo "❌ Failed to connect to the SQLite database: " . $e->getMessage() . PHP_EOL;
    exit();
}

$sqlSelect = "SELECT * FROM students";

$statement = $pdo->query($sqlSelect);
$studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
$studentList = [];

foreach ($studentDataList as $studentData) {
    try {
        $studentList[] = new Student(
            $studentData['id'],
            $studentData['name'],
            new DateTimeImmutable($studentData['birth_date'])
        );
    } catch (DateMalformedStringException $e) {
        echo "❌ Error: " . $e->getMessage() . PHP_EOL;
    }
}

var_dump($studentList);