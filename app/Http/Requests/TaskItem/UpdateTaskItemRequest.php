<?php

namespace App\Http\Requests\TaskItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_id' => 'sometimes|required|exists:tasks,id',
            'title' => 'sometimes|required|string|max:255',
            'is_done' => 'boolean',
        ];
    }
}
