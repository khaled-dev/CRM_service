<?php

namespace App\Http\Requests\Activity;

use App\Http\Requests\BaseRequest;
use App\Models\Activity;
use Illuminate\Validation\Rule;

class UpdateRequest extends BaseRequest
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
            'contact_id' => 'nullable|string|max:255|exists:contracts,_id',
            'outcome' => 'nullable|string|max:255',
            'date' => 'nullable|date_format:Y-m-d',
            'note' => 'nullable|string|max:255',
            'type' => [
                'nullable',
                'string',
                Rule::in(Activity::TYPES),
            ],
        ];
    }
}
