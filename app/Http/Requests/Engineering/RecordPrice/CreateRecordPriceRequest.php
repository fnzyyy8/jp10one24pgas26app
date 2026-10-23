<?php

namespace App\Http\Requests\Engineering\RecordPrice;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRecordPriceRequest extends FormRequest
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
            'unit_price_id' => 'required|exists:unit_prices,id',
            'date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }
}
