<?php

namespace Oussamamater\RateExchanger;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Oussamamater\RateExchanger\Commands\RateExchangerCommand;
use Oussamamater\RateExchanger\Contracts\ExchangeRateService;
use Oussamamater\RateExchanger\Http\Middleware\EnsureRatesAreCached;
use Oussamamater\RateExchanger\Services\CacheRatesService;
use Oussamamater\RateExchanger\Services\ECBExchangeRateService;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RateExchangerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('rate-exchanger')
            ->hasConfigFile()
            ->hasCommand(RateExchangerCommand::class);
    }

    public function bootingPackage()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('ratesCached', EnsureRatesAreCached::class);
    }

    public function registeringPackage()
    {
        $this->app->bind(ExchangeRateService::class, ECBExchangeRateService::class);
        $this->app->singleton(CacheRatesService::class, function (Application $app) {
            return new CacheRatesService($app->make(ExchangeRateService::class));
        });
    }

    public function packageRegistered()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('rate-exchanger.prefix'),
            'middleware' => config('rate-exchanger.middleware'),
        ];
    }
}
