<?php

namespace Oussamamater\RateExchanger\Exceptions;

final class RateExchangeApiTimeoutException extends ExchangeRateException
{
    public static function forApi($apiUrl)
    {
        return new self(
            "The rate exchange API [$apiUrl] timed out. Please try again later."
        );
    }
}
