<?php

namespace App\Http\Requests\Lead;

use App\Http\Requests\BaseRequest;
use App\Models\Customer;
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
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'status'  => [
                'nullable',
                'string',
                Rule::in(Customer::STATUS)
            ],
            'type' => 'nullable|string|max:255',
        ];
    }
}
