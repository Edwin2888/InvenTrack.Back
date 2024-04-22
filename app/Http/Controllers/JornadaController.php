<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Jornada\IJornadaServicio;
use Symfony\Component\HttpFoundation\Response;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class JornadaController extends Controller
{
    protected IJornadaServicio $jornadaServicio;
    public function __construct(IJornadaServicio $iJornadaServicio)
    {
        $this->jornadaServicio = $iJornadaServicio;
    }
    public function iniciarJornada(Request $request): void
    {
        $fecha = Carbon::now();
        $this->jornadaServicio->iniciarJornada($fecha);
        return;

    }

    public function cerrarJornada(Request $request): void
    {
        $fecha = Carbon::now();
        $this->jornadaServicio->cerrarJornada($fecha);
        return;

    }

    public function jornadaActual(): JsonResponse
    {
        $jornadaActual = $this->jornadaServicio->obtenerJornadaActual();
        return new JsonResponse($jornadaActual, Response::HTTP_OK);
    }
}
