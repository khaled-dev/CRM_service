<?php

namespace App\Http\Requests\Opportunity;

use App\Http\Requests\BaseRequest;
use App\Models\Opportunity;
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
            'deal_value' => 'nullable|digits_between:1,10',
            'probability' => 'nullable|string|max:255',
            'close_date' => 'nullable|date_format:Y-m-d',
            'stage' => [
                'nullable',
                'string',
                Rule::in(Opportunity::STAGES)
            ],
        ];
    }
}
