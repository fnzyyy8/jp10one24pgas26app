<?php

namespace App\Http\Requests\Engineering\UnitPrice;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SyncUnitPriceRequest extends FormRequest
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
            'item_detail_ids' => [
                'present',
                'array',
            ],

            'item_detail_ids.*' => [
                'nullable',
                'integer',
                'distinct',
                'exists:item_details,id',
            ],
        ];
    }

}
