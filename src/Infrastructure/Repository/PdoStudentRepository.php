<?php

namespace Athena272\Pdo\Infrastructure\Repository;

use Athena272\Pdo\Domain\Models\Phone;
use Athena272\Pdo\Domain\Models\Student;
use Athena272\Pdo\Domain\Repository\StudentRepository;
use DateTimeInterface;
use RunTimeException;
use PDO;
use PDOStatement;
use DateTimeImmutable;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
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

    private function fillPhonesOf(Student $student): void
    {
        $sqlQuery = 'SELECT id, area_code, number FROM phones where student_id = :student_id';
        $statement = $this->connection->prepare($sqlQuery);
        $statement->bindValue('student_id', $student->getId());
        $statement->execute();

        $phoneDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($phoneDataList as $phoneData) {
            $phone = new Phone(
                $phoneData['id'],
                $phoneData['area_code'],
                $phoneData['number']
            );

            $student->addPhone($phone);
        }
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

        if (!$statement) {
            throw new RuntimeException($this->connection->errorInfo()[2]);
        }

        $success = $statement->execute([
            ':name' => $student->getName(),
            ':birth_date' => $student->getBirthDate()->format('Y-m-d')
        ]);

        if ($success) {
            $student->setId($this->connection->lastInsertId());
        }

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

    /**
     * @throws \DateMalformedStringException
     */
    public function studentsWithPhones(): array
    {
        $sqlQuery = 'SELECT students.id, 
                            students.name, 
                            students.birth_date, 
                            phones.id AS phone_id,
                            phones.area_code,
                            phones.number
                            FROM students 
                            JOIN phones ON students.id = phones.student_id';
        $statement = $this->connection->query($sqlQuery);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach ($result as $student) {
            if (!array_key_exists($student['id'], $studentList)) {
                $studentList[$student['id']] = new Student(
                    $student['id'],
                    $student['name'],
                    new DateTimeImmutable($student['birth_date']),
                );
            }

            $phone = new Phone($student['phone_id'], $student['area_code'], $student['number']);
            $studentList[$student['id']]->addPhone($phone);
        }

        return $studentList;
    }
}