<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'codigo' => 'required|string|between:3,100|unique:productos,codigo,' . $this->id,
            'descripcion' => 'required|string|between:3,100',
            'precioSugerido' => 'numeric',
            'idCategoria' => 'numeric',
            'aplicaStock' => 'required|boolean',
        ];
    }
}
