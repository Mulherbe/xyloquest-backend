<?php

namespace App\Http\Requests\Log;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'action' => 'sometimes|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'action.string' => 'L\'action doit être une chaîne de caractères.',
            'action.max' => 'L\'action ne doit pas dépasser 255 caractères.',
        ];
    }
}
