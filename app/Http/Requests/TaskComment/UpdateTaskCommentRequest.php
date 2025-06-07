<?php

namespace App\Http\Requests\TaskComment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_id' => 'sometimes|required|exists:tasks,id',
            'content' => 'sometimes|required|string',
        ];
    }
}
