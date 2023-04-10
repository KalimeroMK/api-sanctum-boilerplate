<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|',
            'email' => 'nullable|email|max:254|unique:users',
            'password' => 'nullable',
            'phone' => 'nullable',
            'image' => 'nullable',
            'date_of_birth' => 'nullable|date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
