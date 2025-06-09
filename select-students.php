<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Athena272\Pdo\Infrastructure\Repository\PdoStudentRepository;

$pdo = ConnectionCreator::createConnection();
$repository = new PdoStudentRepository($pdo);
$studentList = $repository->allStudents();

var_dump($studentList);

