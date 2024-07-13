<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\BaseRequest;
use App\Models\Customer;
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
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'country' => 'required|string|max:255',
            'status' => [
                'required',
                'string',
                Rule::in(Customer::STATUS),
            ],
            'type' => 'required|string|max:255',
        ];
    }
}
