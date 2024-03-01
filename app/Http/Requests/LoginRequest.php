<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LoginRequest extends FormRequest
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
            'username' => 'bail|required|max:100',
            'password' => 'bail|required|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'username.max' => 'Username maksimal 100 karakter.',
            'password.max' => 'Password maksimal 100 karakter.',
            'username.required' => 'Field username harus ada.',
            'password.required' => 'Field Password harus ada.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => collect($errors->all())->implode("\n"),
            'data' => null,
        ], ResponseAlias::HTTP_OK));
    }

}
