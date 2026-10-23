<?php

namespace App\Http\Requests\ProjectControl;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectControlPlanRequest extends FormRequest
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
            'boq_id' => ['required', 'integer', 'exists:boqs,id'],
            'customer_category' => ['string', 'between:1,100'],
            'section' => 'required|string|between:1,255',
            'category' => 'nullable|string|between:1,255',
            'sub_category' => 'nullable|string|between:1,255',
            'item_detail' => 'required|string|between:1,255',
            'volume' => 'required|numeric',
            'unit' => 'required|string|between:1,255',
            'unit_price' => 'required|numeric',
        ];
    }
}
