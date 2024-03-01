<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RegisterUserRequest extends FormRequest
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
            'nik' => 'bail|required',
            'name' => 'bail|required',
            'roleId' => 'bail|required',
            'address' => 'nullable',
            'birthInfo' => 'nullable',
            'jobTitle' => 'nullable',
            'gender' => 'bail|required|boolean',
            'creatorId' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'username.max' => 'Username maksimal 100 karakter.',
            'password.max' => 'Password maksimal 100 karakter.',
            'nik.required' => 'Field nik harus ada.',
            'username.required' => 'Field username harus ada.',
            'password.required' => 'Field password harus ada.',
            'name.required' => 'Field name harus ada.',
            'roleId.required' => 'Field role id harus ada.',
            'gender.required' => 'Field gender harus ada.',
            'gender.boolean' => 'Field gender harus berupa angka 1 (laki-laki) atau 0 (perempuan).',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => collect($errors->all())->implode(','),
            'data' => null,
        ], ResponseAlias::HTTP_OK));
    }

}
