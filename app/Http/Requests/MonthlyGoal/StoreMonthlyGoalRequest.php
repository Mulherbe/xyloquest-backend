<?php

namespace App\Http\Requests\MonthlyGoal;

use Illuminate\Foundation\Http\FormRequest;

class StoreMonthlyGoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adapte selon ton système d'auth
    }

    public function rules(): array
    {
        return [
            'year' => 'required|integer|min:2000|max:2100',
            'month' => 'required|integer|min:1|max:12',
            'goal_points' => 'required|integer|min:0',
        ];
    }
    public function messages(): array
    {
        return [
            'year.required' => 'L\'année est requise.',
            'year.integer' => 'L\'année doit être un entier.',
            'year.min' => 'L\'année doit être supérieure ou égale à 2000.',
            'year.max' => 'L\'année doit être inférieure ou égale à 2100.',
            'month.required' => 'Le mois est requis.',
            'month.integer' => 'Le mois doit être un entier.',
            'month.min' => 'Le mois doit être supérieur ou égal à 1.',
            'month.max' => 'Le mois doit être inférieur ou égal à 12.',
            'goal_points.required' => 'Les points de but sont requis.',
            'goal_points.integer' => 'Les points de but doivent être un entier.',
            'goal_points.min' => 'Les points de but doivent être supérieurs ou égaux à 0.',
        ];
    }
}
