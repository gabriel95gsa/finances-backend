<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationErrorResponseTrait {
    /**
     * @param Validator $validator
     * @return void
     *
     * @throws HttpResponseException;
     */
    public function validationErrors(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'message' => 'Invalid data sent',
            'errors' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
