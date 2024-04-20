<?php

namespace App\Domain\Jornada;

use App\Models\Jornada;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

interface IJornadaServicio
{
    public function iniciarJornada(Carbon $fecha): Jornada;
    public function cerrarJornada(Carbon $fecha): Jornada;

    public function obtenerFecha(Request $request): Carbon;
}
