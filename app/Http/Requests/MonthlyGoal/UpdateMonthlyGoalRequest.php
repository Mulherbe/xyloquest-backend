<?php

namespace App\Http\Requests\MonthlyGoal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonthlyGoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'goal_points' => 'required|integer|min:0',
        ];
    }
    public function messages(): array
    {
        return [
            'goal_points.required' => 'Les points de but sont requis.',
            'goal_points.integer' => 'Les points de but doivent être un entier.',
            'goal_points.min' => 'Les points de but doivent être supérieurs ou égaux à 0.',
        ];
    }
}
    