<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\BaseRequest;
use App\Models\Account;
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
            'name' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'annual_revenue' => 'nullable|string|max:255',
            'status' => [
                'nullable',
                'string',
                Rule::in(Account::STATUS),
            ],
        ];
    }
}
