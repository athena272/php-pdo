<?php

namespace Athena272\Pdo\Domain\Repository;

use Athena272\Pdo\Domain\Models\Student;
use DateTimeInterface;

interface StudentRepository
{
    public function allStudents(): array;
    public function studentsBirthAt(DateTimeInterface $birthDate): array;
    public function save(Student $student): bool;
    public function remove(Student $student): bool;
}