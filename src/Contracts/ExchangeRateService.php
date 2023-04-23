<?php

namespace Oussamamater\RateExchanger\Contracts;

interface ExchangeRateService
{
    public function getRates(): array;
}
