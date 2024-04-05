<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecetaRequest extends FormRequest
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
            'titulo' => 'required|string',
            'ingredientes' => 'required|string',
            'num_personas' => 'required|numeric',
            'tiempo_preparacion' => 'required|string',
            'descripcion' => 'required|string',
            'ruta_imagen_principal' => 'nullable|string',
            'categorias_recetas_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ];
    }
}
