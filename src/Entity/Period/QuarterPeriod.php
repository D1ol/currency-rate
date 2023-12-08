<?php

declare(strict_types=1);

namespace App\Entity\Period;

final class QuarterPeriod extends Period
{
    public function getDateStart(): \DateTimeImmutable
    {
        return (new \DateTimeImmutable())->sub(new \DateInterval('P3M'));
    }
}
