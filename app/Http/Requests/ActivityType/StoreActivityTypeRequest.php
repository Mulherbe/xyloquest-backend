<?php

namespace App\Http\Requests\ActivityType;

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
            'default_points_per_hour' => 'required|integer|min:0',
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
            'default_points_per_hour.required' => 'Les points par heure sont requis.',
            'default_points_per_hour.integer' => 'Les points par heure doivent être un entier.',
            'default_points_per_hour.min' => 'Les points par heure doivent être supérieurs ou égaux à 0.',
        ];
    }
}
