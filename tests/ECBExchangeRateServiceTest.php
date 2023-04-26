<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Oussamamater\RateExchanger\Exceptions\RateExchangeApiTimeoutException;
use Oussamamater\RateExchanger\Services\CacheRatesService;
use Oussamamater\RateExchanger\Services\ECBExchangeRateService;

it('caches rates', function () {
    $cacheKey = config('rate-exchanger.rates_cache_key');

    $this->assertTrue(! Cache::has($cacheKey));

    $xml = new SimpleXMLElement(getFixture('eurofxref-daily.xml'));

    Http::fake([
        config('rate-exchanger.ecb_url') => Http::response($xml->asXML()),
    ]);

    $service = new CacheRatesService(new ECBExchangeRateService());
    $service->cacheRates();

    $this->assertTrue(Cache::has($cacheKey));

    $cachedRates = Cache::get($cacheKey);

    $this->assertIsArray($cachedRates);

    $this->assertArrayHasKey('USD', $cachedRates);
    $this->assertEquals(1.0972, $cachedRates['USD']);
});

it('caches only once', function () {
    $xml = new SimpleXMLElement(getFixture('eurofxref-daily.xml'));

    Http::fake([
        config('rate-exchanger.ecb_url') => Http::response($xml->asXML()),
    ]);

    $service = new CacheRatesService(new ECBExchangeRateService());
    $service->cacheRates();
    $service->cacheRates();

    Http::assertSentCount(1);
});

it('throws an exception if the api times out', function () {
    $apiUrl = config('rate-exchanger.ecb_url');

    Http::fake([
        $apiUrl => Http::response('', 408),
    ]);

    $service = new ECBExchangeRateService();
    $service->getRates();

})->throws(RateExchangeApiTimeoutException::class);
