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

    public function resultadoJornada(int $idJornada = null): JsonResponse
    {
        $resultado = $this->registradoraServicio->resultadoJornada($idJornada);
        return new JsonResponse($resultado, Response::HTTP_OK);
    }
}
