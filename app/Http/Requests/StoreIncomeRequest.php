<?php

namespace App\Http\Requests;

use App\Http\Traits\ValidationErrorResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeRequest extends FormRequest
{
    use ValidationErrorResponseTrait;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required_without:recurrent_income_id|exclude_with:recurrent_income_id|string|min:3|max:255',
            'recurrent_income_id' => 'nullable|exists:recurrent_incomes,id',
            'value' => 'required_without:recurrent_income_id|exclude_with:recurrent_income_id|decimal:0,2',
            'period_date' => 'required|date_format:Y-m',
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $this->validationErrors($validator);
    }
}
