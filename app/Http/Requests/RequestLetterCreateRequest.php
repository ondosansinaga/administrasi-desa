<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RequestLetterCreateRequest extends FormRequest
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
            'userId' => 'bail|required|integer',
            'letterId' => 'bail|required|integer',
            'dateRequest' => 'bail|required|date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [
            'userId.required' => 'Field user id harus ada.',
            'letterId.required' => 'Field id surat harus ada.',
            'dateRequest.required' => 'Field tanggal permintaan harus ada.',

            'userId.integer' => 'Field user id harus berupa angka.',
            'letterId.integer' => 'Field id surat harus berupa angka.',

            'dateRequest.date_format' => 'Format tanggal yang diterima tahun-bulan-tanggal.',
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
