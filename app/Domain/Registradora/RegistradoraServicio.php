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
        if ($request->dinero == 0)
            throw new InvenTrackException("No puedes generar un movimiento con valor 0.", Response::HTTP_BAD_REQUEST);

        if ($request->movimiento !== MovimientoCajaRegistradora::AJUSTES && $request->dinero < 1)
            throw new InvenTrackException("Solo puedes enviar movimientos negativos para el movimiento de ajuste.", Response::HTTP_BAD_REQUEST);

        $existeMovimientoFinal = $this->movimientoPorTipo(MovimientoCajaRegistradora::SALDO_FINAL);
        if ($existeMovimientoFinal)
            throw new InvenTrackException("Ya hay un movimiento de saldo final para la jornada, no puedes ingresar mas movimientos.", Response::HTTP_BAD_REQUEST);

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

    public function resultadoJornada()
    {
        $saldoFinal = $this->movimientoPorTipo(MovimientoCajaRegistradora::SALDO_FINAL)->dinero ?? 0;
        $saldoEsperado = $this->obtenerSaldoFinal();

        return [
            'saldoFinal' => $saldoFinal,
            'saldoEsperado' => $saldoEsperado,
            'exitoso' => $saldoFinal == $saldoEsperado
        ];
    }

    protected function obtenerSaldoFinal(): ?float
    {
        return Registradora::where('idJornada', $this->idJornada)
            ->whereIn('movimiento', MovimientoCajaRegistradora::movimientosASumar())
            ->sum('dinero') - Registradora::where('idJornada', $this->idJornada)
                ->whereIn('movimiento', MovimientoCajaRegistradora::movimientosARestar())
                ->sum('dinero');
    }
    protected function saldoInicial(RegistradoraRequest $request): void
    {
        $existeMovimiento = $this->movimientoPorTipo(MovimientoCajaRegistradora::SALDO_INICIAL);

        if ($existeMovimiento)
            throw new InvenTrackException("Solo puedes ingresar un saldo inicial 1 vez por jornada.", Response::HTTP_BAD_REQUEST);

        $this->crearRegistro($request);
    }
    protected function saldoFinal(RegistradoraRequest $request): void
    {
        $existeMovimientoInicial = $this->movimientoPorTipo(MovimientoCajaRegistradora::SALDO_INICIAL);
        if (!$existeMovimientoInicial)
            throw new InvenTrackException("Debes tener un movimiento de saldo inicial.", Response::HTTP_BAD_REQUEST);

        $this->crearRegistro($request);
    }
    protected function generarMovimiento(RegistradoraRequest $request): void
    {
        $existeMovimientoInicial = $this->movimientoPorTipo(MovimientoCajaRegistradora::SALDO_INICIAL);
        if (!$existeMovimientoInicial)
            throw new InvenTrackException("Debes tener un movimiento de saldo inicial.", Response::HTTP_BAD_REQUEST);

        $this->crearRegistro($request);
    }

    protected function crearRegistro(RegistradoraRequest $request): void
    {
        $movimientoRegistradora = new Registradora();
        $movimientoRegistradora->idJornada = $this->idJornada;
        $movimientoRegistradora->movimiento = $request->movimiento;
        $movimientoRegistradora->dinero = $request->dinero;
        $movimientoRegistradora->idUsuario = auth()->user()->id;
        $movimientoRegistradora->descripcion = $request->descripcion;
        $movimientoRegistradora->save();
    }

    private function movimientoPorTipo(string $tipoMovimiento)
    {
        return Registradora::where('idJornada', $this->idJornada)
            ->where('movimiento', $tipoMovimiento)
            ->first();
    }
}