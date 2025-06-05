<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Domain\Models\Student;
use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$sqlSelect = "SELECT * FROM students";

$statement = $pdo->query($sqlSelect);
while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
    try {
        $student = new Student(
            $studentData['id'],
            $studentData['name'],
            new DateTimeImmutable($studentData['birth_date'])
        );

        echo $student->age() . PHP_EOL;
    } catch (DateMalformedStringException $e) {
        echo "❌ Error: " . $e->getMessage() . PHP_EOL;
    }
}
var_dump($statement->fetchColumn(1));

