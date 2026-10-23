<?php

namespace App\Http\Requests\Engineering\ItemDetail;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateItemDetailRequest extends FormRequest
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
            'section.name' => [
                'required',
                'string',
                'max:255',
            ],
            'section.sort_order' => [
                'required',
                'integer',
                'min:0',
            ],
            'category.name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'category.sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'subCategory.name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'subCategory.sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'itemDetail.scope' => [
                'required',
                'string',
            ],
            'itemDetail.name' => [
                'required',
                'string',
                'max:255',
            ],
            'itemDetail.unit' => [
                'required',
                'string',
                'max:255',
            ],
            'itemDetail.sort_order' => [
                'required',
                'integer',
                'min:0',
            ]

        ];
    }
}
