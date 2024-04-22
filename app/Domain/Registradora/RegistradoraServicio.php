<?php

namespace App\Domain\Registradora;

use App\Models\Registradora;
use App\Enums\MovimientoCajaRegistradora;
use App\Exceptions\InvenTrackException;
use App\Domain\Jornada\JornadaServicio;
use App\Http\Requests\RegistradoraRequest;
use Symfony\Component\HttpFoundation\Response;

class RegistradoraServicio extends JornadaServicio implements IRegistradoraServicio
{
    public function __construct()
    {
        parent::__construct();
        if (!isset($this->idJornada))
            throw new InvenTrackException("Debe iniciar una jornada.", Response::HTTP_NOT_FOUND);

    }
    public function movimiento(RegistradoraRequest $request): void
    {
        switch ($request->movimiento) {
            case MovimientoCajaRegistradora::SALDO_INICIAL:
                $this->saldoInicial($request);
                break;
            case MovimientoCajaRegistradora::SALDO_FINAL:
                $this->saldoFinal($request);
                break;
            default:
                $this->generarMovimiento($request);
        }
    }
    protected function saldoInicial(RegistradoraRequest $request): void
    {
        $existeMovimiento = $this->movimientoPorTipo(MovimientoCajaRegistradora::SALDO_INICIAL);

        if ($existeMovimiento)
            throw new InvenTrackException("Solo puedes ingresar un saldo inicial 1 vez por jornada.", Response::HTTP_BAD_REQUEST);

        $movimientoRegistradora = new Registradora();
        $movimientoRegistradora->idJornada = $this->idJornada;
        $movimientoRegistradora->movimiento = MovimientoCajaRegistradora::SALDO_INICIAL;
        $movimientoRegistradora->dinero = $request->dinero;
        $movimientoRegistradora->idUsuario = auth()->user()->id;
        $movimientoRegistradora->descripcion = $request->input('descripcion');
        $movimientoRegistradora->save();
    }
    protected function saldoFinal(RegistradoraRequest $request): void
    {

        $movimientosRegistradora = Registradora::where('idJornada', $this->idJornada)
            ->whereIn('movimiento', [MovimientoCajaRegistradora::SALDO_INICIAL, MovimientoCajaRegistradora::SALDO_FINAL])
            ->get();

        $cantMovimientosInicial = $movimientosRegistradora->filter(function ($movimiento) {
            return $movimiento->movimiento == MovimientoCajaRegistradora::SALDO_INICIAL;
        })->count();

        if ($cantMovimientosInicial === 0)
            throw new InvenTrackException("Debes tener un movimiento de saldo inicial.", Response::HTTP_BAD_REQUEST);

        $cantMovimientosFinal = $movimientosRegistradora->filter(function ($movimiento) {
            return $movimiento->movimiento == MovimientoCajaRegistradora::SALDO_FINAL;
        })->count();

        if ($cantMovimientosFinal > 0)
            throw new InvenTrackException("No puedes tener dos movimientos de saldo final en una misma jornada.", Response::HTTP_BAD_REQUEST);
        $movimientoRegistradora = new Registradora();
        $movimientoRegistradora->idJornada = $this->idJornada;
        $movimientoRegistradora->movimiento = MovimientoCajaRegistradora::SALDO_FINAL;
        $movimientoRegistradora->dinero = $request->dinero;
        $movimientoRegistradora->idUsuario = auth()->user()->id;
        $movimientoRegistradora->descripcion = $request->input('descripcion');
        $movimientoRegistradora->save();
    }
    protected function generarMovimiento(RegistradoraRequest $request): void
    {
        $existeMovimientoInicial = $this->movimientoPorTipo(MovimientoCajaRegistradora::SALDO_INICIAL);
        if (!$existeMovimientoInicial)
            throw new InvenTrackException("Debes tener un movimiento de saldo inicial.", Response::HTTP_BAD_REQUEST);

        if ($request->dinero == 0)
            throw new InvenTrackException("No puedes generar un movimiento con valor 0.", Response::HTTP_BAD_REQUEST);

        if ($request->movimiento !== MovimientoCajaRegistradora::AJUSTES && $request->dinero < 1)
            throw new InvenTrackException("Solo puedes enviar movimientos negativos para el movimiento de ajuste.", Response::HTTP_BAD_REQUEST);

        $existeMovimientoFinal = $this->movimientoPorTipo(MovimientoCajaRegistradora::SALDO_FINAL);

        if ($existeMovimientoFinal)
            throw new InvenTrackException("Ya hay un movimiento de saldo final para la jornada, no puedes ingresar mas movimientos.", Response::HTTP_BAD_REQUEST);

        $movimientoRegistradora = new Registradora();
        $movimientoRegistradora->idJornada = $this->idJornada;
        $movimientoRegistradora->movimiento = $request->movimiento;
        $movimientoRegistradora->dinero = $request->dinero;
        $movimientoRegistradora->idUsuario = auth()->user()->id;
        $movimientoRegistradora->descripcion = $request->input('descripcion');
        $movimientoRegistradora->save();
    }

    private function movimientoPorTipo(string $tipoMovimiento)
    {
        return Registradora::where('idJornada', $this->idJornada)
            ->where('movimiento', $tipoMovimiento)
            ->first();
    }

}