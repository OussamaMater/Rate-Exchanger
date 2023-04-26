<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

it('converts currency', function () {
    $xml = new SimpleXMLElement(getFixture('eurofxref-daily.xml'));

    Http::fake([
        config('rate-exchanger.ecb_url') => Http::response($xml->asXML()),
    ]);

    Cache::put(config('rate-exchanger.rates_cache_key'), [
        'USD' => 1.2,
    ]);

    $response = $this->get(route('rate-exchanger.convertCurrency', [
        'amount' => 100,
        'to' => 'usd',
    ]));

    $response->assertOk();

    $response->assertJson([
        'from' => 'EUR',
        'to' => 'USD',
        'amount' => 100,
        'converted' => 120,
        'rates' => [
            'USD to EUR' => 0.8333,
            'EUR to USD' => 1.2,
        ],
    ]);
});

it('returns an error if currency is invalid', function () {
    $xml = new SimpleXMLElement(getFixture('eurofxref-daily.xml'));

    Http::fake([
        config('rate-exchanger.ecb_url') => Http::response($xml->asXML()),
    ]);

    Cache::put(config('rate-exchanger.rates_cache_key'), [
        'USD' => 1.2,
    ]);

    $response = $this->get(route('rate-exchanger.convertCurrency', [
        'amount' => 100,
        'to' => 'TND',
    ]));

    $response->assertStatus(400);

    $response->assertJson([
        'error' => 'Invalid currency code: TND',
    ]);
});
