<?php

namespace App\Models;

use App\Enums\EstadoJornada;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    use HasFactory;
    protected $fillable = ['fechaInicial', 'fechaFinal', 'estado', 'id', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($jornada) {
            $estadossPermitidos = [EstadoJornada::ABIERTA, EstadoJornada::CERRADA];
            if (!in_array($jornada->estado, $estadossPermitidos)) {
                throw new \InvalidArgumentException("Invalido estato" . $jornada->estado);
            }
        });
    }
}
