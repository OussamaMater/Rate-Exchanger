<?php

namespace Oussamamater\RateExchanger\Http\Responses;

use Illuminate\Http\JsonResponse;

class CurrencyConversionResponse
{
    public static function success(array $conversionData, float $rate): JsonResponse
    {
        return response()->json([
            'from' => $conversionData['from'],
            'to' => $conversionData['to'],
            'amount' => $conversionData['amount'],
            'converted' => round($conversionData['amount'] * $rate, 4),
            'rates' => [
                "{$conversionData['to']} to {$conversionData['from']}" => round(1 / $rate, 4),
                "{$conversionData['from']} to {$conversionData['to']}" => $rate,
            ],
        ]);
    }

    public static function error(string $currency, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'error' => "Invalid currency code: {$currency}",
        ], $statusCode);
    }
}
