<?php

namespace App\Http\Requests\Opportunity;

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
            'deal_value' => 'required|digits_between:1,10',
            'probability' => 'required|string|max:255',
            'close_date' => 'nullable|date_format:Y-m-d',
            'stage' => [
                'required',
                'string',
                Rule::in(Opportunity::STAGES)
            ],
        ];
    }
}
