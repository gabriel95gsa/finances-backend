<?php

namespace App\Http\Requests;

use App\Http\Traits\ValidationErrorResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreRecurrentExpenseRequest extends FormRequest
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
            'description' => 'required|string|min:3|max:255',
            'default_value' => 'required|decimal:0,2',
            'limit_value' => 'decimal:0,2',
            'due_day' => 'integer|min:1|max:31',
            'status' => 'boolean',
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
