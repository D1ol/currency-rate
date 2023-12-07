<?php

declare(strict_types=1);

namespace App\Messenger\SynchronizeCurrencyRate;

use App\DTO\RateDTO;

class SynchronizeCurrencyRateMessage
{
    private int $currencyId;
    private RateDTO $rateDTO;

    public function __construct(
        int $currencyId,
        RateDTO $rateDTO,
    ) {
        $this->currencyId = $currencyId;
        $this->rateDTO = $rateDTO;
    }

    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    public function getRateDTO(): RateDTO
    {
        return $this->rateDTO;
    }
}
