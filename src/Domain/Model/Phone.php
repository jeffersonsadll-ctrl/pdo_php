<?php 

namespace Alura\Pdo\Domain\Model;

class Phone
{
    /**
     * Summary of __construct
     * @param int|null $id
     * @param string $areaCode
     * @param string $number
     */
    public function __construct(
        private ?int $id,
        private string $areaCode,
        private string $number
    ) {}

    /**
     * Returns the unique identifier for this phone.
     * @return int|null
     */
    public function id(): ?int
    {
        return $this->id;
    }

    public function areaCode(): string
    {
        return $this->areaCode;
    }

    public function number(): string
    {
        return $this->number;
    }
}