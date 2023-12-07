<?php

namespace App\Help;

interface PeriodInterface
{
    public function getDateStart(): \DateTimeImmutable;

    public function getDateEnd(): \DateTimeImmutable;
}
