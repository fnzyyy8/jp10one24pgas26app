<?php

namespace App\Http\Requests\ManPower;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_card_number' => 'required|string|min:16|max:20',
            'name' => 'required|string|max:255',
            'based' => 'required|string|max:255',
            'phone_number' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'work_status' => 'required|in:not active,active,on work',
            'last_follow_up' => 'required|date',
            'work_scope_ids' => ['sometimes', 'nullable', 'array'],
            'work_scope_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:work_scopes,id',
            ],
        ];
    }
}
