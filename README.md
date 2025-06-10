# Projeto PHP com PDO

Este repositório contém arquivos que demonstram o uso de PDO (PHP Data Objects) em um projeto PHP orientado a objetos, incluindo CRUD e separação em camadas de domínio e infraestrutura.

## Estrutura de Arquivos e Conteúdo

### `php-pdo-main/.gitattributes`

```php
# Auto detect text files and perform LF normalization
* text=auto

```

### `php-pdo-main/.gitignore`

```php
.idea/
/vendor/
database.sqlite

```

### `php-pdo-main/LICENSE`

```php
MIT License

Copyright (c) 2025 athena272

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

```

### `php-pdo-main/README.md`

```php
# php-pdo


```

### `php-pdo-main/composer.json`

```php
{
    "name": "athena272/php-pdo",
    "description": "Make a connection with SQLite",
    "type": "project",
    "license": "MIT",
    "autoload": {
        "psr-4": {
            "Athena272\\Pdo\\": "src/"
        }
    },
    "authors": [
        {
            "name": "athena272",
            "email": "guilhermera272@gmail.com"
        }
    ],
    "require": {
      "ext-pdo": "*"
    }
}

```

### `php-pdo-main/composer.lock`

```php
{
    "_readme": [
        "This file locks the dependencies of your project to a known state",
        "Read more about it at https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies",
        "This file is @generated automatically"
    ],
    "content-hash": "9bbc71f418de13726c1c45b60857892a",
    "packages": [],
    "packages-dev": [],
    "aliases": [],
    "minimum-stability": "stable",
    "stability-flags": {},
    "prefer-stable": false,
    "prefer-lowest": false,
    "platform": {},
    "platform-dev": {},
    "plugin-api-version": "2.6.0"
}

```

### `php-pdo-main/create-class.php`

```php
<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Athena272\Pdo\Infrastructure\Repository\PdoStudentRepository;
use Athena272\Pdo\Domain\Models\Student;

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();
try {
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
    $connection->commit();
} catch (RuntimeException $e) {
    echo $e->getMessage() . PHP_EOL;
    $connection->rollBack();
}
```

### `php-pdo-main/database-connection.php`

```php
<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;

$connection = ConnectionCreator::createConnection();

//$connection->exec("INSERT INTO phones (area_code, number, student_id) VALUES ('24', '999999999', 1),('21', '222222222', 1);");
//exit();

$createTableSql = '
    CREATE TABLE IF NOT EXISTS students (
        id INTEGER PRIMARY KEY,
        name TEXT,
        birth_date TEXT
    );

    CREATE TABLE IF NOT EXISTS phones (
        id INTEGER PRIMARY KEY,
        area_code TEXT,
        number TEXT,
        student_id INTEGER,
        FOREIGN KEY(student_id) REFERENCES students(id)
    );
';

$connection->exec($createTableSql);
```

### `php-pdo-main/delete-student.php`

```php
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
```

### `php-pdo-main/index.php`

```php
<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Domain\Models\Student;

$student = new Student(null, 'Vinicius Dias', new DateTimeImmutable('1997-10-15'));

var_dump($student);

echo $student->age();


```

### `php-pdo-main/insert-student.php`

```php
<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Domain\Models\Student;
use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$student = new Student(
    null,
    'Patricia Freitas',
    new DateTimeImmutable('1986-10-25')
);
//$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (?, ?)";
$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date)";
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(':name', $student->getName());
$statement->bindValue(':birth_date', $student->getBirthDate()->format('Y-m-d'));
if($statement->execute()) {
    echo "Studend add successfully." . PHP_EOL;
}

echo $sqlInsert . PHP_EOL;

//var_dump($pdo->exec($sqlInsert));
```

### `php-pdo-main/select-students-with-phone.php`

```php
<?php

use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Athena272\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::createConnection();
$repository = new PdoStudentRepository($connection);

$studentList = $repository->studentsWithPhones();

var_dump($studentList);
```

### `php-pdo-main/select-students.php`

```php
<?php

require_once 'vendor/autoload.php';

use Athena272\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Athena272\Pdo\Infrastructure\Repository\PdoStudentRepository;

$pdo = ConnectionCreator::createConnection();
$repository = new PdoStudentRepository($pdo);
$studentList = $repository->allStudents();

var_dump($studentList);


```

### `php-pdo-main/src/Domain/Models/Phone.php`

```php
<?php

namespace Athena272\Pdo\Domain\Models;

class Phone
{
    private ?int $id;
    private string $areaCode;
    private string $number;

    public function __construct(?int $id, string $areaCode, string $number)
    {
        $this->id = $id;
        $this->areaCode = $areaCode;
        $this->number = $number;
    }

    public function formattedPhone(): string
    {
        return "({$this->areaCode}) {$this->number}";
    }
}
```

### `php-pdo-main/src/Domain/Models/Student.php`

```php
<?php

namespace Athena272\Pdo\Domain\Models;

use DateTimeImmutable;
use DateTimeInterface;
use DomainException;

class Student
{
    private ?int $id;
    private string $name;
    private DateTimeInterface $birthDate;
    /** @var Phone[]  */
    private array $phones = [];

    public function __construct(?int $id, string $name, DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        if (!is_null($this->id)) {
            throw new DomainException(message: "You can only set an ID once");
        }

        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function age(): int
    {
        return $this->birthDate
            ->diff(new DateTimeImmutable())
            ->y;
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones[] = $phone;
    }
    /** @return Phone[] */
    public function getPhones(): array {
        return $this->phones;
    }
}
```

### `php-pdo-main/src/Domain/Repository/StudentRepository.php`

```php
<?php

namespace Athena272\Pdo\Domain\Repository;

use Athena272\Pdo\Domain\Models\Student;
use DateTimeInterface;

interface StudentRepository
{
    public function allStudents(): array;
    public function studentsWithPhones(): array;
    public function studentsBirthAt(DateTimeInterface $birthDate): array;
    public function save(Student $student): bool;
    public function remove(Student $student): bool;
}
```

### `php-pdo-main/src/Infrastructure/Persistence/ConnectionCreator.php`

```php
<?php

namespace Athena272\Pdo\Infrastructure\Persistence;

use PDO;
use PDOException;

class ConnectionCreator
{
    public static function createConnection(): PDO
    {
        $databasePath = __DIR__ . DIRECTORY_SEPARATOR . '../../../database.sqlite';

        try {
            $pdo = new PDO("sqlite:$databasePath");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            echo "✅ Successfully connected to the SQLite database." . PHP_EOL;
            return $pdo;
        } catch (PDOException $e) {
            echo "❌ Failed to connect to the SQLite database: " . $e->getMessage();
            exit();
        }
    }
}
```

### `php-pdo-main/src/Infrastructure/Repository/PdoStudentRepository.php`

```php
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
```

