<?php

declare(strict_types=1);

namespace App\DTO;

class RateDTO
{
    private string $effectiveDate;
    private float $bid;
    private float $ask;

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

    public function getBid(): float
    {
        return $this->bid;
    }

    public function setBid(float $bid): RateDTO
    {
        $this->bid = $bid;

        return $this;
    }

    public function getAsk(): float
    {
        return $this->ask;
    }

    public function setAsk(float $ask): RateDTO
    {
        $this->ask = $ask;

        return $this;
    }
}
