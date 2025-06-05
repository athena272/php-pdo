<?php

namespace Athena272\Pdo\Infrastructure\Repository;

use Athena272\Pdo\Domain\Models\Student;
use Athena272\Pdo\Domain\Repository\StudentRepository;
use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;
use DateTimeInterface;
use PDO;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = ConnectionCreator::createConnection();
    }

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