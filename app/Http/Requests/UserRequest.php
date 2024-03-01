<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserRequest extends FormRequest
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
            'nik' => 'bail|required',
            'name' => 'bail|required',
            'birthInfo' => 'nullable',
            'jobTitle' => 'nullable',
            'address' => 'nullable',
            'gender' => 'bail|required|boolean',
            'image' => 'nullable|image',
        ];
    }

    public function messages(): array
    {
        return [
            'nik.required' => 'Field nik harus ada.',
            'name.required' => 'Field name harus ada.',
            'gender.required' => 'Field gender harus ada.',
            'gender.boolean' => 'Field gender harus berupa angka 1 (laki-laki) atau 0 (perempuan).',
            'image.image' => 'Field image harus berupa gambar.',
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
