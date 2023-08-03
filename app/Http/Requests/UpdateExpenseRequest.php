<?php

namespace App\Http\Requests;

use App\Http\Traits\ValidationErrorResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Closure;

class UpdateExpenseRequest extends FormRequest
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
            'user_id' => 'prohibited|exclude',
            'expenses_category_id' => [
                'sometimes',
                'nullable',
                'exists:expenses_categories,id',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->expense->recurrent_expense_id) {
                        $fail('Expense category can`t be updated when the expense is current.');
                    }
                }
            ],
            'description' => 'sometimes|string|min:3|max:255',
            'recurrent_expense_id' => 'prohibited|exclude',
            'value' => 'sometimes|decimal:0,2',
            'period_date' => 'sometimes|date_format:Y-m',
            'due_day' => 'sometimes|integer|between:1,31',
        ];
    }

    /**
     * @param $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (isset($this->period_date) && $this->expense->recurrentExpense !== null) {
                $validator->errors()->add(
                    'period_date',
                    'Period date not allowed to be updated when the expense is recurrent.'
                );
            }

            if (isset($this->due_day) && $this->expense->recurrentExpense !== null) {
                $validator->errors()->add(
                    'due_day',
                    'Due day not allowed to be updated if the expense is recurrent.'
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
