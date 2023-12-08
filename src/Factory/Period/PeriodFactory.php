<?php

declare(strict_types=1);

namespace App\Factory\Period;

use App\Entity\Period\MonthPeriod;
use App\Entity\Period\PeriodInterface;
use App\Entity\Period\QuarterPeriod;
use App\Entity\Period\WeekPeriod;
use App\Enum\PeriodEnum;

class PeriodFactory
{
    public static function getPeriod(PeriodEnum $periodEnum): PeriodInterface
    {
        return match ($periodEnum) {
            PeriodEnum::Week => new WeekPeriod(),
            PeriodEnum::Month => new MonthPeriod(),
            PeriodEnum::Quarter => new QuarterPeriod(),
        };
    }
}
