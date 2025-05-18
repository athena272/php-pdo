<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Domain\Models\Student;

$student = new Student(null, 'Vinicius Dias', new DateTimeImmutable('1997-10-15'));

var_dump($student);

echo $student->age();