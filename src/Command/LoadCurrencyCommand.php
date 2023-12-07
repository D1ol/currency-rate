<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Currency\Currency;
use App\Enum\CurrencyEnum;
use App\Repository\Currency\CurrencyRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:currency:load')]
class LoadCurrencyCommand extends Command
{
    public function __construct(
        private readonly CurrencyRepository $currencyRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $count = 0;

        $this->currencyRepository->wrapInTransaction(function () use (&$count) {
            foreach (CurrencyEnum::arrayReversed() as $name => $symbol) {
                if (!$this->currencyRepository->findOneBySymbol($symbol)) {
                    $currency = new Currency();
                    $currency
                        ->setName($name)
                        ->setSymbol($symbol);
                    $this->currencyRepository->save($currency);
                    ++$count;
                }
            }
        });

        $io->success(sprintf('Successfully load %s currencies', $count));

        return Command::SUCCESS;
    }
}
