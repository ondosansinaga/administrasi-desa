<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class NewsRequest extends FormRequest
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
            'title' => 'bail|required',
            'content' => 'bail|required',
            'creatorId' => 'bail|required|integer',
            'image' => 'nullable|image',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Field judul harus ada.',
            'content.required' => 'Field isi harus ada.',
            'creatorId.required' => 'Field creator id harus ada.',
            'creatorId.integer' => 'Field creator id harus berupa angka.',
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
