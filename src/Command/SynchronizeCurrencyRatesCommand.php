<?php

declare(strict_types=1);

namespace App\Command;

use App\DTO\CurrencyExchangeRatesDTO;
use App\Messenger\SynchronizeCurrencyRate\SynchronizeCurrencyRateMessage;
use App\Repository\Currency\CurrencyRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(name: 'app:currency:synchronize:rates')]
class SynchronizeCurrencyRatesCommand extends Command
{
    public function __construct(
        private HttpClientInterface $nblHttpClient,
        private CurrencyRepository $currencyRepository,
        private SerializerInterface $serializer,
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $currencies = $this->currencyRepository->findAll();
        $startDate = new \DateTimeImmutable('first day of january this year');
        $dateEnd = new \DateTimeImmutable();

        foreach ($currencies as $currency) {
            $request = $this->nblHttpClient->request('GET',
                sprintf('exchangerates/rates/c/%s/%s/%s/?format=json',
                    $currency->getSymbol(),
                    $startDate->format('Y-m-d'),
                    $dateEnd->format('Y-m-d')),
                [
                    'query' => ['format' => 'json'],
                ]);

            try {
                $currencyExchangeRate = $this->serializer->deserialize($request->getContent(), CurrencyExchangeRatesDTO::class, JsonEncoder::FORMAT);
                $currencyExchangeRate->setCurrency($currency);

                foreach ($currencyExchangeRate->getRates() as $rate) {
                    $synchronizeCurrencyRateMessage = new SynchronizeCurrencyRateMessage($currency->getId(), $rate);
                    $this->messageBus->dispatch($synchronizeCurrencyRateMessage);
                }
            } catch (\Exception $e) {
                $io->error(sprintf('Error with currency: %s', $currency->getSymbol()));
            }
        }

        $io->success('Success');

        return Command::SUCCESS;
    }
}
