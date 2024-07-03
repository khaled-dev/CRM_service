<?php

namespace App\Http\Requests\Activity;

use App\Models\Activity;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contract_id' => 'nullable|string|max:255|exists:contracts,_id',
            'outcome' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'note' => 'nullable|string|max:255',
            'type' => [
                'nullable',
                'string',
                Rule::in(Activity::TYPES)
            ],
        ];
    }
}
