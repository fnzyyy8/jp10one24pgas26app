<?php

namespace App\Http\Requests\Shared;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DataTableRequest extends FormRequest
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
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1'],
            'search' => ['nullable', 'string'],
            'sort_by' => ['nullable', 'string', 'max:100'],
            'sort_direction' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }

    public function page(): int
    {
        return $this->integer('page', 1);
    }

    public function perPage(): int
    {
        return $this->integer('per_page', 10);
    }

    public function search(): ?string
    {
        $search = $this->input('search');
        return $this->filled($search) ? trim($search) : null;

    }

    public function sortBy(): ?string
    {
        return $this->input('sort_by');
    }

    public function sortDirection(): ?string
    {
        return $this->input('sort_direction', 'desc');
    }
}
