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
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'start_date'       => ['required', 'date'],
            'end_date'         => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_recurring'     => ['required', 'boolean'],
            'recurrence_rule'  => ['nullable', 'string', 'in:daily,weekly,every_3_days'],
            'completed_at'     => ['nullable', 'date'],
            'activity_type_id' => ['required', 'exists:activity_types,id'],
            'status'           => ['nullable', 'string', 'in:pending,done,skipped'],
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est requis.',
            'start_date.required' => 'La date de début est requise.',
            'end_date.after_or_equal' => 'La date de fin doit être après ou égale à la date de début.',
            'activity_type_id.exists' => 'Le type d\'activité sélectionné n\'existe pas.',
            'status.in' => "Le statut doit être 'pending', 'done' ou 'skipped'.",
        ];
    }
}
