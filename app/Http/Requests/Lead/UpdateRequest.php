<?php

namespace App\Http\Requests\Lead;

use App\Http\Requests\BaseRequest;
use App\Models\Lead;
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
            'email' => 'nullable|string|email|max:255',
            'phone' => 'nullable|string|max:255',
            'source' => [
                'nullable',
                'string',
                Rule::in(Lead::SOURCES),
            ],
            'interest_level' => [
                'nullable',
                'string',
                Rule::in(Lead::INTERESTS),
            ],
            'status' => [
                'nullable',
                'string',
                Rule::in(Lead::STATUS),
            ],
        ];
    }
}
