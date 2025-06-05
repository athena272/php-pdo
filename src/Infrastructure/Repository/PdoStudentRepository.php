<?php

namespace Athena272\Pdo\Infrastructure\Repository;

use Athena272\Pdo\Domain\Models\Student;
use Athena272\Pdo\Domain\Repository\StudentRepository;
use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;
use DateTimeInterface;
use PDO;
use PDOStatement;
use DateTimeImmutable;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = ConnectionCreator::createConnection();
    }

    public function allStudents(): array
    {
        $sqlQuery = 'SELECT * FROM students';
        $statement = $this->connection->query($sqlQuery);

        return $this->hydrateStudentList($statement);
    }

    public function studentsBirthAt(DateTimeInterface $birthDate): array
    {
        $sqlQuery = 'SELECT * FROM students WHERE birthDate = :birthDate';
        $statement = $this->connection->prepare($sqlQuery);
        $statement->bindValue('birthDate', $birthDate->format('Y-m-d'));
        $statement->execute();

        return $this->hydrateStudentList($statement);
    }

    private function hydrateStudentList(PDOStatement $statement): array
    {
        $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $studentList[] = new Student(
                $studentData['id'],
                $studentData['name'],
                new DateTimeImmutable($studentData['birth_date']),
            );
        }

        return $studentList;
    }

    public function save(Student $student): bool
    {
        if ($student->getId() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    public function insert(Student $student): bool
    {
        $insertQuery = 'INSERT INTO students (name, birth_date) VALUES (:name, :birth_date)';
        $statement = $this->connection->prepare($insertQuery);

        $success = $statement->execute([
            ':name' => $student->getName(),
            ':birth_date' => $student->getBirthDate()->format('Y-m-d')
        ]);

        return $success;
    }

    public function update(Student $student): bool
    {
        $updateQuery = 'UPDATE students SET name = :name, birth_data = :birth_data WHERE id = :id';
        $statement = $this->connection->prepare($updateQuery);
        $statement->bindValue(':name', $student->getName());
        $statement->bindValue(':birth_data', $student->getBirthDate()->format(format: 'Y-m-d'));
        $statement->bindValue(':id', $student->getId(), PDO::PARAM_INT);

        return $statement->execute();
    }

    public function remove(Student $student): bool
    {
        $statement = $this->connection->prepare('DELETE FROM students WHERE id = ?');
        $statement->bindValue(1, $student->getId(), PDO::PARAM_INT);

        return $statement->execute();
    }
}