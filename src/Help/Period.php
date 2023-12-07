<?php

declare(strict_types=1);

namespace App\Help;

abstract class Period implements PeriodInterface
{
    public function getDateEnd(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
