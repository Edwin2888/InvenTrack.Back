<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistradoraRequest;
use App\Domain\Registradora\IRegistradoraServicio;

class RegistradoraController extends Controller
{
    protected IRegistradoraServicio $registradoraServicio;
    public function __construct(IRegistradoraServicio $iRegistradoraServicio)
    {
        $this->registradoraServicio = $iRegistradoraServicio;
    }
    public function movimiento(RegistradoraRequest $request): void
    {
        $this->registradoraServicio->movimiento($request);
    }
}
