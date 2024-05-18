<?php

namespace Modules\Role\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    /**
     * @return string[]
     */
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