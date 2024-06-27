<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
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
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
            'name' => 'required|max:255',
            'company_name' => 'required|max:255',
            'address' => 'required|max:255',
            'country' => 'required|max:255',
            'status'  => [
                'required',
                Rule::in(Customer::STATUS)
            ],
            'type' => 'required|max:255',
        ];
    }
}
