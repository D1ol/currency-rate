<?php

declare(strict_types=1);

namespace App\DTO;

class RateDTO
{
    private string $effectiveDate;
    private float $mid;

    public function getEffectiveDate(): string
    {
        return $this->effectiveDate;
    }

    /**
     * @throws \Exception
     */
    public function getEffectiveDateTimeImmutable(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->effectiveDate);
    }

    public function setEffectiveDate(string $effectiveDate): RateDTO
    {
        $this->effectiveDate = $effectiveDate;

        return $this;
    }

    public function getMid(): float
    {
        return $this->mid;
    }

    public function setMid(float $mid): RateDTO
    {
        $this->mid = $mid;

        return $this;
    }
}
