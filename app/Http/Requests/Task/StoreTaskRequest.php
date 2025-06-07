<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'task_status_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'position' => 'nullable|integer',
            'activity_id' => 'nullable|exists:activities,id',
            'points' => 'nullable|integer',
            'is_completed' => 'boolean',
        ];
    }
}
