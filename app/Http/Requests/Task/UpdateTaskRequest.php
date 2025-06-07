<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'sometimes|required|exists:projects,id',
            'task_status_id' => 'sometimes|required|exists:task_statuses,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'position' => 'nullable|integer',
            'activity_id' => 'nullable|exists:activities,id',
            'points' => 'nullable|integer',
            'is_completed' => 'boolean',
        ];
    }
}
