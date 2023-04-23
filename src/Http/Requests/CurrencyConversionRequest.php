<?php

namespace Oussamamater\RateExchanger\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyConversionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'amount' => ['required', 'numeric'],
            'to' => ['required'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        $validated['to'] = strtoupper($validated['to']);
        $validated['from'] = config('rate-exchanger.from');

        return $validated;
    }
}
