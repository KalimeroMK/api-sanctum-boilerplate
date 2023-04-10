<?php

namespace Modules\Role\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|unique:roles,name',
            'permission' => 'required|integer|exists:permissions,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}