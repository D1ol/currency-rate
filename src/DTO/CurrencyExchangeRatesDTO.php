<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Currency\Currency;

class CurrencyExchangeRatesDTO
{
    private ?Currency $currency = null;

    /**
     * @var RateDTO[]
     */
    private array $rates;

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): CurrencyExchangeRatesDTO
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return RateDTO[]
     */
    public function getRates(): array
    {
        return $this->rates;
    }

    /**
     * @param RateDTO[] $rates
     *
     * @return $this
     */
    public function setRates(array $rates): CurrencyExchangeRatesDTO
    {
        $this->rates = $rates;

        return $this;
    }
}
