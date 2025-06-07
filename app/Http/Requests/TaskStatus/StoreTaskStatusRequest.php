<?php

namespace App\Http\Requests\TaskStatus;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
        ];
    }
}
