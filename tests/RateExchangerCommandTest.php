<?php

use Illuminate\Support\Facades\Artisan;
use Mockery\MockInterface;
use Oussamamater\RateExchanger\Commands\RateExchangerCommand;
use Oussamamater\RateExchanger\Services\CacheRatesService;

it('can cache currency rates', function () {
    $this->app->instance(
        CacheRatesService::class,
        Mockery::mock(CacheRatesService::class, function (MockInterface $mock) {
            $mock->shouldReceive('cacheRates')->once();
        })
    );

    $output = Artisan::call('currency-rates:cache');
    $this->assertEquals(RateExchangerCommand::SUCCESS, $output);
    $this->assertStringContainsString('Rates cached.', Artisan::output());
});
