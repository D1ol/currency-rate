<?php

declare(strict_types=1);

namespace App\Service\ExchangeCurrency;

use App\Entity\Currency\Currency;
use App\Entity\Rate\Rate;
use App\Enum\ActionEnum;

class ExchangeCurrency
{
    private float $amount;

    private ActionEnum $action;

    private Currency $targetCurrency;

    private ?Rate $rate = null;

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): ExchangeCurrency
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAction(): ActionEnum
    {
        return $this->action;
    }

    public function setAction(ActionEnum $action): ExchangeCurrency
    {
        $this->action = $action;

        return $this;
    }

    public function getTargetCurrency(): Currency
    {
        return $this->targetCurrency;
    }

    public function setTargetCurrency(Currency $targetCurrency): ExchangeCurrency
    {
        $this->targetCurrency = $targetCurrency;

        return $this;
    }

    public function getRate(): ?Rate
    {
        return $this->rate;
    }

    public function setRate(?Rate $rate): ExchangeCurrency
    {
        $this->rate = $rate;

        return $this;
    }

    public function getExchangedAmount(): float
    {
        return match ($this->action) {
            ActionEnum::Buy => $this->amount / $this->rate->getBid(),
            ActionEnum::Sell => $this->amount / $this->rate->getAsk(),
        };
    }
}
