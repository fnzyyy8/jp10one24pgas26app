<?php

namespace App\Http\Requests\Project;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
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
            'price_list_id' => ['required','integer','exists:price_lists,id'],
            'project_name' => ['required', 'string'],
            'project_code' => ['required', 'string'],
            'project_number' => ['required', 'string'],
            'category' => ['required', 'string'],
            'budget' => ['required', 'numeric'],
            'area' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'isMultipleArea' => ['required', 'boolean', 'default' => false],
        ];
    }
}
