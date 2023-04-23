<?php

namespace Oussamamater\RateExchanger\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Oussamamater\RateExchanger\RateExchangerServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Oussamamater\\RateExchanger\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app)
    {
        return [
            RateExchangerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_rate-exchanger_table.php.stub';
        $migration->up();
        */

        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(
            $app['config']['app.cipher'] == 'AES-128-CBC' ? 16 : 32
        )));
    }
}
