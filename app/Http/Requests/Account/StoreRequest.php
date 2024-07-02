<?php

namespace App\Http\Requests\Account;

use App\Models\Account;
use App\Models\Opportunity;
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
            'name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'annual_revenue' => 'required|string|max:255',
            'stage' => [
                'required',
                'string',
                Rule::in(Account::STATUS)
            ],
        ];
    }
}
