<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class CoreRequest extends BaseFormRequest
{

    public function authorize(): bool
    {
        return true;
    }
}