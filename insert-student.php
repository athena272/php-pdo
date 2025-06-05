<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Domain\Models\Student;
use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

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