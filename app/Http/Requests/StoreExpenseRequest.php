<?php

namespace App\Http\Requests;

use App\Http\Traits\ValidationErrorResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'expenses_category_id' => 'sometimes|nullable|exclude_with:recurrent_expense_id|exists:expenses_categories,id',
            'description' => 'required_without:recurrent_expense_id|exclude_with:recurrent_expense_id|string|min:3|max:255',
            'recurrent_expense_id' => 'nullable|prohibits:expenses_category_id,description,value,due_day|exists:recurrent_expenses,id',
            'value' => 'required_without:recurrent_expense_id|exclude_with:recurrent_expense_id|decimal:0,2',
            'period_date' => 'required|date_format:Y-m',
            'due_day' => 'sometimes|exclude_with:recurrent_expense_id|integer|between:1,31',
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

    /**
     * @return void
     */
    protected function prepareForValidation()
    {
        // Always add auth user id to the form request automatically
        $this->merge(['user_id' => auth()->user()->id]);
    }
}
