<?php

use Illuminate\Support\Facades\Route;
use Oussamamater\RateExchanger\Http\Controllers\ConvertCurrency;

Route::get('convert', ConvertCurrency::class)->name('convertCurrency');
