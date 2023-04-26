<?php

namespace Oussamamater\RateExchanger\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Oussamamater\RateExchanger\Services\CacheRatesService;

class EnsureRatesAreCached
{
    public function __construct(
        protected CacheRatesService $cacheService
    ) {
    }

    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        $this->cacheService->cacheRates();

        return $next($request);
    }
}
