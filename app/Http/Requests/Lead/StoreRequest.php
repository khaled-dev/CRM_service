<?php

namespace App\Http\Requests\Lead;

use App\Http\Requests\BaseRequest;
use App\Models\Lead;
use Illuminate\Validation\Rule;

class StoreRequest extends BaseRequest
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
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'source' => [
                'required',
                'string',
                Rule::in(Lead::SOURCES),
            ],
            'interest_level' => [
                'required',
                'string',
                Rule::in(Lead::INTERESTS),
            ],
            'status' => [
                'required',
                'string',
                Rule::in(Lead::STATUS),
            ],
        ];
    }
}
