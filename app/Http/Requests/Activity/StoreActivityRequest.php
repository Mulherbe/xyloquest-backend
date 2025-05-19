<?php

namespace App\Http\Requests\Activity;

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
            'user_id'          => ['required', 'exists:users,id'],
            'start_date'       => ['required', 'date'],
            'end_date'         => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_recurring'     => ['required', 'boolean'],
            'recurrence_rule'  => ['nullable', 'string', 'in:daily,weekly,every_3_days'],
            'completed_at'     => ['nullable', 'date'],
            'activity_type_id' => ['required', 'exists:activity_types,id'],
            'status'           => ['nullable', 'string', 'in:pending,done,skipped'],
            'earned_points'    => ['nullable', 'integer', 'min:0'], // <- ajouté ici
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'            => 'Le titre est requis.',
            'title.string'              => 'Le titre doit être une chaîne de caractères.',
            'title.max'                 => 'Le titre ne doit pas dépasser 255 caractères.',
            'description.string'        => 'La description doit être une chaîne de caractères.',
            'user_id.required'          => "L'identifiant de l'utilisateur est requis.",
            'user_id.exists'            => "L'identifiant de l'utilisateur doit exister dans la table users.",
            'start_date.required'       => 'La date de début est requise.',
            'start_date.date'           => 'La date de début doit être une date valide.',
            'end_date.date'             => 'La date de fin doit être une date valide.',
            'end_date.after_or_equal'   => 'La date de fin doit être postérieure ou égale à la date de début.',
            'is_recurring.required'     => 'La récurrence est requise.',
            'is_recurring.boolean'      => 'La récurrence doit être un booléen.',
            'recurrence_rule.string'    => 'La règle de récurrence doit être une chaîne de caractères.',
            'recurrence_rule.in'        => "La règle de récurrence doit être l'une des valeurs suivantes : daily, weekly, every_3_days.",
            'completed_at.date'         => "La date d'achèvement doit être une date valide.",
            'activity_type_id.required' => "L'identifiant du type d'activité est requis.",
            'activity_type_id.exists'   => "L'identifiant du type d'activité doit exister dans la table activity_types.",
            'status.in'                 => "Le statut doit être l'une des valeurs suivantes : pending, done, skipped.",
            'earned_points.integer'     => "Le nombre de points doit être un entier.",
            'earned_points.min'         => "Le nombre de points ne peut pas être négatif.",
        ];
    }
}
