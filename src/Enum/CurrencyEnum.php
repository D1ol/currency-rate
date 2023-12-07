<?php

namespace App\Enum;

enum CurrencyEnum: string
{
    use EnumToArray;

    case Dollar = 'usd';
    case EURO = 'eur';
    case Zloty = 'pln';
}
