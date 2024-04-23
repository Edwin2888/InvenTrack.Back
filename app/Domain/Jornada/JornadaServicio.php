<?php

namespace App\Domain\Jornada;

use App\Models\Jornada;
use App\Enums\EstadoJornada;
use Illuminate\Support\Carbon;
use App\Exceptions\InvenTrackException;
use Symfony\Component\HttpFoundation\Response;

class JornadaServicio implements IJornadaServicio
{
    protected ?Jornada $jornadaActual = null;
    protected ?int $idJornada = null;

    public function __construct()
    {
        $jornada = Jornada::where('estado', EstadoJornada::ABIERTA)->first();
        if (!is_null($jornada)) {
            $this->jornadaActual = $jornada;
            $this->idJornada = $jornada->id;
        }
    }
    public function iniciarJornada(Carbon $fecha): Jornada
    {
        if (isset($this->jornadaActual))
            throw new InvenTrackException("No puede iniciar una nueva jornada porque actualmente hay una abierta.", Response::HTTP_NOT_FOUND);
        $nuevaJornada = new Jornada();
        $nuevaJornada->fechaInicial = $fecha->format('Y-m-d H:i:s');
        $nuevaJornada->estado = EstadoJornada::ABIERTA;
        $nuevaJornada->save();
        return $nuevaJornada;

    }
    public function cerrarJornada(Carbon $fecha): Jornada
    {
        if (!isset($this->jornadaActual))
            throw new InvenTrackException("No puede cerrar la jornada porque actualmente no hay ninguna abierta.", Response::HTTP_NOT_FOUND);
        $jornada = $this->jornadaActual;
        $jornada->fechaFinal = $fecha->format('Y-m-d H:i:s');
        $jornada->estado = EstadoJornada::CERRADA;
        $jornada->save();
        return $jornada;
    }

    public function obtenerJornadaActual(): ?Jornada
    {
        return $this->jornadaActual;
    }
}