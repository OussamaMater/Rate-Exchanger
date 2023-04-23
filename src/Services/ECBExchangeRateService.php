<?php

namespace Oussamamater\RateExchanger\Services;

use Illuminate\Support\Facades\Http;
use Oussamamater\RateExchanger\Contracts\ExchangeRateService;
use Oussamamater\RateExchanger\Exceptions\RateExchangeApiTimeoutException;
use SimpleXMLElement;

class ECBExchangeRateService implements ExchangeRateService
{
    protected function getRatesFromApi(): string
    {
        $currencyApi = config('rate-exchanger.ecb_url');

        $response = Http::get($currencyApi);

        throw_if($response->failed(), RateExchangeApiTimeoutException::forApi($currencyApi));

        return $response->body();
    }

    protected function formatRate(string $response): array
    {
        $xml = new SimpleXMLElement($response);

        $rates = [];

        foreach ($xml->Cube->Cube->Cube as $cube) {
            $rates[(string) $cube['currency']] = (float) $cube['rate'];
        }

        $rates['EUR'] = 1;

        return $rates;
    }

    public function getRates(): array
    {
        return $this->formatRate($this->getRatesFromApi());
    }
}
