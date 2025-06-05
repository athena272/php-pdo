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

    }

    public function remove(Student $student): bool
    {
        $statement = $this->connection->prepare('DELETE FROM students WHERE id = ?');
        $statement->bindValue(1, $student->getId(), PDO::PARAM_INT);

        return $statement->execute();
    }
}