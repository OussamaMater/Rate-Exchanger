<?php

return [
    /**
     * The default currency to convert to.
     */
    'from' => 'EUR',

    /**
     * The default prefix to be applied to routes.
     */
    'prefix' => 'rate-exchanger',

    /**
     * The default middleware group(s) to apply to the package's routes.
     */
    'middleware' => ['web', 'ratesCached'],

    /**
     * The URL for the daily currency exchange rates from the European Central Bank.
     */
    'ecb_url' => 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml',

    /**
     * The cache key used to store the daily currency exchange rates.
     */
    'rates_cache_key' => 'daily-currency-rates',
];
