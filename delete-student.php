<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$sqlDelete = "DELETE FROM students WHERE id = :id";
$preparedStatement = $pdo->prepare($sqlDelete);
$preparedStatement->bindValue(':id', 2, PDO::PARAM_INT);

if ($preparedStatement->execute()) {
    echo "Student deleted successfully." . PHP_EOL;
}