<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateMovieRequest extends FormRequest
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
            'name' => 'required',
            'premiere' => 'required',
            'poster' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'name.required' => 'Se requiere el nombre',
            'premiere.required' => 'Se requiere la fecha del la pelicula',
            'poster.required' => 'Se requiere el poster',
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
