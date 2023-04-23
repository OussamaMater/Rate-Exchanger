<?php

namespace Oussamamater\RateExchanger\Http\Middleware;

use Closure;
use Oussamamater\RateExchanger\Services\CacheRatesService;

class EnsureRatesAreCached
{
    public function __construct(
        protected CacheRatesService $cacheService
    ) {
    }

    public function handle($request, Closure $next)
    {
        $this->cacheService->cacheRates();

        return $next($request);
    }
}
