<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PlaceRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'place' => 'required',
            'active' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'place.required' => 'Se requiere la fecha del turno',
            'active.required' => 'El estado es requerido',
        ];
    }

    public function failedValidation(Validator $validator): HttpResponseException{
        throw new HttpResponseException(response()->json([
            'msg' => 'Validation errors',
            'success' => false,
            'data' => $validator->errors(),
            'exceptions' => 'validation',
        ], 400));
    }
}
