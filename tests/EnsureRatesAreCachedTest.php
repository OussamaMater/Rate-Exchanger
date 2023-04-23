<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Oussamamater\RateExchanger\Http\Middleware\EnsureRatesAreCached;

it('sets cache for controllers', function () {
    $this->assertFalse(Cache::has(config('rate-exchanger.rates_cache_key')));

    Route::get('/', function () {
        return 'Hello, world!';
    })->middleware(EnsureRatesAreCached::class);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Hello, world!');

    $this->assertTrue(Cache::has(config('rate-exchanger.rates_cache_key')));
});
