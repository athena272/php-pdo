<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Athena272\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Athena272\Pdo\Domain\Models\Student;

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();
$nicoSteppat = new Student(
    null,
    'Nico Steppat',
    new DateTimeImmutable('1985-05-01')
);
$studentRepository->save($nicoSteppat);
$samanthaLopes = new Student(
    null,
    'Samantha Lopes',
    new DateTimeImmutable('1985-05-01')
);
$studentRepository->save($samanthaLopes);

$connection->rollBack();
//$connection->commit();