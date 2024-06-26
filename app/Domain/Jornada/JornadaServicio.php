<?php

namespace App\Domain\Jornada;

use App\Models\Jornada;
use App\Enums\EstadoJornada;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\InvenTrackException;
use Symfony\Component\HttpFoundation\Response;

const LLAVE_JORNADA_ACTUAL = 'Jornada_Actual';
class JornadaServicio implements IJornadaServicio
{
    protected ?Jornada $jornadaActual = null;
    protected ?int $idJornada = null;

    public function __construct()
    {
        $jornadaArray = Redis::hGetAll(LLAVE_JORNADA_ACTUAL);
        if (!empty($jornadaArray) && isset($jornadaArray['id'])) {
            $this->jornadaActual = new Jornada($jornadaArray);
            $this->idJornada = $jornadaArray['id'];
        } else {
            $jornada = Jornada::where('estado', EstadoJornada::ABIERTA)->first();
            if (!is_null($jornada)) {
                $this->jornadaActual = $jornada;
                $this->idJornada = $jornada->id;

                Redis::hMSet(LLAVE_JORNADA_ACTUAL, $jornada->toArray());
            }
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

        Redis::hMSet(LLAVE_JORNADA_ACTUAL, $nuevaJornada->toArray());
        return $nuevaJornada;

    }
    public function cerrarJornada(Carbon $fecha): Jornada
    {
        if (!isset($this->idJornada))
            throw new InvenTrackException("No puede cerrar la jornada porque actualmente no hay ninguna abierta.", Response::HTTP_NOT_FOUND);
        $jornada = Jornada::findOrFail($this->idJornada);
        $jornada->fechaFinal = $fecha->format('Y-m-d H:i:s');
        $jornada->estado = EstadoJornada::CERRADA;
        $jornada->save();

        Redis::del(LLAVE_JORNADA_ACTUAL);
        return $jornada;
    }

    public function obtenerJornadaActual(): ?Jornada
    {
        return $this->jornadaActual;
    }
}