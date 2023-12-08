<?php

declare(strict_types=1);

namespace App\Messenger\SynchronizeCurrencyRate;

use App\Entity\Rate\Rate;
use App\Repository\Currency\CurrencyRepository;
use App\Repository\Rate\RateRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SynchronizeCurrencyRateHandler
{
    public function __construct(
        private RateRepository $rateRepository,
        private CurrencyRepository $currencyRepository,
    ) {
    }

    public function __invoke(SynchronizeCurrencyRateMessage $message): void
    {
        $currency = $this->currencyRepository->findOneBy(['id' => $message->getCurrencyId()]);
        $rateExist = $this->rateRepository->findOneBy(['currency' => $currency, 'date' => $message->getRateDTO()->getEffectiveDateTimeImmutable()]);

        if (!$rateExist) {
            $rate = new Rate();

            $rate
                ->setCurrency($currency)
                ->setDate($message->getRateDTO()->getEffectiveDateTimeImmutable())
                ->setBid($message->getRateDTO()->getBid())
                ->setAsk($message->getRateDTO()->getAsk());

            $this->rateRepository->save($rate, true);
        }
    }
}
