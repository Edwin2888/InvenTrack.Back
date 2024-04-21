<?php

namespace App\Http\Requests;

use ReflectionClass;
use App\Enums\MovimientoCajaRegistradora;
use Illuminate\Foundation\Http\FormRequest;

class RegistradoraRequest extends FormRequest
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
        $reflectionClass = new ReflectionClass(MovimientoCajaRegistradora::class);
        $movimientos = array_values($reflectionClass->getConstants());
        $valoresPermitidos = implode(',', $movimientos);
        return [
            'movimiento' => 'required|string|in:' . $valoresPermitidos,
            'dinero' => 'required|numeric',
            'descripcion' => 'string',
        ];
    }
}
