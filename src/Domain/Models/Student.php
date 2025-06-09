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