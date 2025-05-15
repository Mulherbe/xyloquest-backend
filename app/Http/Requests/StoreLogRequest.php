<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'activity_id' => 'required|exists:activities,id',
            'action' => 'required|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.required' => 'L\'identifiant de l\'utilisateur est requis.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',
            'activity_id.required' => 'L\'identifiant de l\'activité est requis.',
            'activity_id.exists' => 'L\'activité sélectionnée n\'existe pas.',
            'action.required' => 'L\'action est requise.',
            'action.string' => 'L\'action doit être une chaîne de caractères.',
            'action.max' => 'L\'action ne doit pas dépasser 255 caractères.',
        ];
    }
}
