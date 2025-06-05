<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Domain\Models\Student;

$databasePath = __DIR__ . DIRECTORY_SEPARATOR . 'database.sqlite';

try {
    $pdo = new PDO("sqlite:$databasePath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Successfully connected to the SQLite database." . PHP_EOL;
} catch (PDOException $e) {
    echo "❌ Failed to connect to the SQLite database: " . $e->getMessage();
    exit();
}

$student = new Student(
    null,
    'Patricia Freitas',
    new DateTimeImmutable('1986-10-25')
);
//$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (?, ?)";
$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date)";
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(':name', $student->getName());
$statement->bindValue(':birth_date', $student->getBirthDate()->format('Y-m-d'));
if($statement->execute()) {
    echo "Studend add successfully." . PHP_EOL;
}

echo $sqlInsert . PHP_EOL;


//var_dump($pdo->exec($sqlInsert));