<?php

namespace App\Http\Requests\ManPower;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkScopeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
