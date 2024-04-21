<?php

namespace App\Domain\Registradora;

use App\Enums\MovimientoCajaRegistradora;
use App\Http\Requests\RegistradoraRequest;

interface IRegistradoraServicio
{
    public function movimiento(RegistradoraRequest $request): void;
    // public function saldoInicial(): void;
    // public function saldoFinal(): void;

    // public function generarMovimiento(MovimientoCajaRegistradora $movimiento): void;

}