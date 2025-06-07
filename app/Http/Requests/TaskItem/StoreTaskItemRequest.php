<?php

namespace App\Http\Requests\TaskItem;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_id' => 'required|exists:tasks,id',
            'title' => 'required|string|max:255',
            'is_done' => 'boolean',
        ];
    }
}
