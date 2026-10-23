<?php

namespace App\Http\Requests\ProjectControl\Plan;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SyncPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'unit_price_ids' => [
                'present',
                'array',
            ],
            'unit_price_ids.*'=>[
                'integer',
                'distinct',
                'exists:unit_prices,id',
            ]
        ];
    }
}
