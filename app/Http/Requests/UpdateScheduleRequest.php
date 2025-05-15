<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recurrence_rule' => 'sometimes|string|max:255',
            'next_occurrence' => 'sometimes|date',
        ];
    }
}
