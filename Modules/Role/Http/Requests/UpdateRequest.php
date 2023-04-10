<?php

namespace Modules\Role\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'permission' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}