<?php

namespace App\Http\Requests\TaskComment;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
        ];
    }
}
