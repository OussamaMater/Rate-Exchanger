<?php

namespace Oussamamater\RateExchanger\Commands;

use Illuminate\Console\Command;
use Oussamamater\RateExchanger\Services\CacheRatesService;

class RateExchangerCommand extends Command
{
    public $signature = 'currency-rates:cache';

    public $description = 'Fetches the latest currency exchange rates from the European Central Bank and caches them.';

    public function handle(CacheRatesService $cacheService): int
    {
        $cacheService->cacheRates();

        $this->info('Rates cached.');

        return self::SUCCESS;
    }
}
