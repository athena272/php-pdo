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