<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAuthRequest extends FormRequest
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
            'name' => 'required',
            'email' => [
                'required',
                'email',
                'unique:users,email',
                'regex:/@(pgnsolution\.co\.id|pgn-solution\.co\.id)$/i'],
            'division' => 'required|in:Site,PSCM',
            'position' => 'required|in:Project Control,Administration and Contract,Finance,HSSE,QAQC,Engineering,General Affair,Procurement,Logistic',
        ];
    }
}
