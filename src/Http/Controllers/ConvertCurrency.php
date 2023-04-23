<?php

namespace Oussamamater\RateExchanger\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Oussamamater\RateExchanger\Http\Requests\CurrencyConversionRequest;
use Oussamamater\RateExchanger\Http\Responses\CurrencyConversionResponse;

class ConvertCurrency
{
    public function __invoke(CurrencyConversionRequest $request): JsonResponse
    {
        $rates = Cache::get(config('rate-exchanger.rates_cache_key'));
        $conversionData = $request->validated();

        if (! array_key_exists($conversionData['to'], $rates)) {
            return CurrencyConversionResponse::error($conversionData['to']);
        }

        $rate = $rates[$conversionData['to']];

        return CurrencyConversionResponse::success($conversionData, $rate);
    }
}
