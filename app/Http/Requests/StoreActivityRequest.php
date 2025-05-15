<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ou logique d'autorisation ici
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'activity_type_id' => 'required|exists:activity_types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'is_recurring' => 'boolean',
        ];
    }
}
