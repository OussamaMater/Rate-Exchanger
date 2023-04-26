<?php

namespace Oussamamater\RateExchanger\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Oussamamater\RateExchanger\Http\Requests\CurrencyConversionRequest;
use Oussamamater\RateExchanger\Http\Responses\CurrencyConversionResponse;

/**
 * @OA\Info(
 *     title="Currency Exchanger API - Swagger Documentation",
 *     description="This API retrieves currency exchange rates through the European Central Bank API.",
 *     version="1.0.0"
 * )
 */
class ConvertCurrency
{
    /**
     *  @OA\Get(
     *      path="/rate-exchanger/convert",
     *      summary="Converts a currency",
     *      tags={"Currency Exchanger"},
     *
     *      @OA\Parameter(
     *          parameter="to",
     *          name="to",
     *          in="query",
     *          description="The currency code to convert to",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          parameter="amount",
     *          name="amount",
     *          in="query",
     *          description="The amount to convert",
     *          required=true,
     *      ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid Currency Code"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Content"
     *     ),
     * )
     */
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
