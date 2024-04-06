<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class MovieRequest extends FormRequest
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
            'name' => 'required|string|unique:movies',
            'premiere' => 'required',
            'poster' => 'required|image|mimes:jpg,png,jpeg,webp,svg',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'Nombre con formato inválido',
            'name.unique' => 'El nombre ya existe en nuestras bases de datos',
            'premiere.required' => 'La fecha de la premiere es requerida',
            'poster.required' => 'El poster de la pelicula es requerido',
            'poster.image' => 'El poster debe ser una imágen',
            'poster.mimes' => 'Formato de imágen no válido',
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
