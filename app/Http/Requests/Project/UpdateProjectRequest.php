<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'goal_points' => 'sometimes|required|integer',
            'current_points' => 'sometimes|required|integer',
            'is_completed' => 'sometimes|required|boolean',
        ];
    }
}
