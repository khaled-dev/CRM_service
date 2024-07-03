<?php

namespace App\Http\Requests\Activity;

use App\Models\Activity;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'contract_id' => 'required|string|max:255|exists:contracts,_id',
            'outcome' => 'required|string|max:255',
            'date' => 'required|date',
            'note' => 'required|string|max:255',
            'type' => [
                'required',
                'string',
                Rule::in(Activity::TYPES)
            ],
        ];
    }
}
