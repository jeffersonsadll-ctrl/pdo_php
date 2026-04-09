<?php

namespace Alura\Pdo\Domain\Model;

class Student
{
    private ?int $id;
    private string $name;
    private \DateTimeInterface $birthDate;

    private array $phones;

    public function __construct(?int $id, string $name, \DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;

        $this->phones = [];
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function birthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function age(): int
    {
        return $this->birthDate
            ->diff(new \DateTimeImmutable())
            ->y;
    }

    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    public function defineId(int $id): void
    {
        if ($this->id !== null) {
            throw new \LogicException('ID já definido para este aluno.');
        }

        $this->id = $id;
    }

    
    public function phones(): array
    {
        return $this->phones;
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones[] = $phone;
    }
}
