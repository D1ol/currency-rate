<?php

declare(strict_types=1);

namespace App\Factory;

use App\Enum\PeriodEnum;
use App\Help\MonthPeriod;
use App\Help\PeriodInterface;
use App\Help\QuarterPeriod;
use App\Help\WeekPeriod;

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
