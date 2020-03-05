<?php

declare(strict_types=1);

namespace App\Request;


class testValidationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email'
        ];
    }
}
