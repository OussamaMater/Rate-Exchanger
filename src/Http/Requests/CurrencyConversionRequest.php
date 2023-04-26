<?php

namespace Oussamamater\RateExchanger\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CurrencyConversionRequest extends FormRequest
{
    public function rules(): array
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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
