<?php

namespace Athena272\Pdo\Infrastructure\Repository;

use Athena272\Pdo\Domain\Models\Student;
use Athena272\Pdo\Domain\Repository\StudentRepository;
use DateTimeInterface;

class PdoStudentRepository implements StudentRepository
{

    public function allStudents(): array
    {
        // TODO: Implement allStudents() method.
    }

    public function studentsBirthAt(DateTimeInterface $birthDate): array
    {
        // TODO: Implement studentsBirthAt() method.
    }

    public function save(Student $student): bool
    {
        // TODO: Implement save() method.
    }

    public function remove(Student $student): bool
    {
        // TODO: Implement remove() method.
    }
}