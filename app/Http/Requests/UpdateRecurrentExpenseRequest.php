<?php

namespace App\Http\Requests;

use App\Http\Traits\ValidationErrorResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRecurrentExpenseRequest extends FormRequest
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
            'expenses_category_id' => 'sometimes|nullable|exists:expenses_categories,id',
            'description' => 'sometimes|string|min:3|max:255',
            'default_value' => 'sometimes|decimal:0,2',
            'limit_value' => 'sometimes|decimal:0,2',
            'due_day' => 'sometimes|integer|min:1|max:31',
            'status' => 'sometimes|boolean',
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
