<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistradoraRequest;
use App\Domain\Registradora\IRegistradoraServicio;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    public function resultadoJornada(): JsonResponse
    {
        $resultado = $this->registradoraServicio->resultadoJornada();
        return new JsonResponse($resultado, Response::HTTP_OK);
    }
}
