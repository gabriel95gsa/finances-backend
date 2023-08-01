<?php

namespace App\Http\Requests;

use App\Http\Traits\ValidationErrorResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIncomeRequest extends FormRequest
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
            'description' => 'sometimes|string|min:3|max:255',
            'recurrent_income_id' => 'prohibited|exclude',
            'value' => 'sometimes|decimal:0,2',
            'period_date' => 'sometimes|date_format:Y-m',
        ];
    }

    /**
     * @param $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (isset($this->period_date) && $this->income->recurrentIncome !== null) {
                $validator->errors()->add(
                    'period_date',
                    'Period date not allowed to be updated if the income is recurrent.'
                );
            }
        });
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
