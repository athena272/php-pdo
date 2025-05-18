<?php

namespace Athena272\Pdo\Domain\Models;

use DateTimeImmutable;
use DateTimeInterface;

class Student
{
    private ?int $id;
    private string $name;
    private DateTimeInterface $birthDate;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function age(): int {
        return $this->birthDate
            ->diff(new DateTimeImmutable())
            ->y;
    }
}