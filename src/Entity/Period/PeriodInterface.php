<?php

namespace App\Entity\Period;

interface PeriodInterface
{
    public function getDateStart(): \DateTimeImmutable;

    public function getDateEnd(): \DateTimeImmutable;
}
