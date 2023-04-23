<?php

namespace Oussamamater\RateExchanger\Services;

use Illuminate\Support\Facades\Cache;
use Oussamamater\RateExchanger\Contracts\ExchangeRateService;

class CacheRatesService
{
    public function __construct(
        private ExchangeRateService $exchangeRatesService
    ) {
    }

    public function cacheRates(): void
    {
        $cacheKey = config('rate-exchanger.rates_cache_key');
        $cacheTime = now()->endOfDay();

        if (! Cache::has($cacheKey)) {
            $rates = $this->exchangeRatesService->getRates();
            Cache::put($cacheKey, $rates, $cacheTime);
        }
    }
}
