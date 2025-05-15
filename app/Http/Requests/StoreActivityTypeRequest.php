<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:10', // ex : #FF00FF
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'color.string' => 'La couleur doit être une chaîne de caractères.',
            'color.max' => 'La couleur ne doit pas dépasser 10 caractères.',
        ];
    }
}

