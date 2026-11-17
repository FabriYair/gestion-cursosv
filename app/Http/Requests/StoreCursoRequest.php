<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string'],
            'creditos' => ['required', 'integer', 'min:1', 'max:10'],
            'docente_id' => ['required', 'exists:docentes,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del curso es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'creditos.required' => 'Debes ingresar la cantidad de créditos.',
            'creditos.integer' => 'Los créditos deben ser un número entero.',
            'creditos.min' => 'El curso debe tener al menos 1 crédito.',
            'creditos.max' => 'El curso no puede superar los 10 créditos.',
            'docente_id.required' => 'Debes seleccionar un docente.',
            'docente_id.exists' => 'El docente seleccionado no existe.',
        ];
    }
}
