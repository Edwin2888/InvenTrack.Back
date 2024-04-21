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
                $this->saldoFinal();
                break;
            default:
                $this->generarMovimiento($request->movimiento);
        }
    }
    protected function saldoInicial(RegistradoraRequest $request): void
    {
        $movimientoInicial = MovimientoCajaRegistradora::SALDO_INICIAL;

        $existeMovimiento = Registradora::where('idJornada', $this->idJornada)
            ->where('movimiento', $movimientoInicial)
            ->first();

        if ($existeMovimiento)
            throw new InvenTrackException("Solo puedes ingresar un saldo inicial 1 vez por jornada.", Response::HTTP_BAD_REQUEST);

        $movimientoRegistradora = new Registradora();
        $movimientoRegistradora->idJornada = $this->idJornada;
        $movimientoRegistradora->movimiento = $movimientoInicial;
        $movimientoRegistradora->dinero = $request->dinero;
        $movimientoRegistradora->idUsuario = auth()->user()->id;
        $movimientoRegistradora->descripcion = $request->input('descripcion');
        $movimientoRegistradora->save();
    }
    protected function saldoFinal(): void
    {
        // $movimientoFinal = MovimientoCajaRegistradora::SALDO_FINAL;

        // $existeMovimiento = Registradora::where('idJornada', $this->idJornada)
        //     ->where('movimiento', $movimientoFinal)
        //     ->first();

        // if ($existeMovimiento)
        //     throw new InvenTrackException("Solo puedes ingresar un saldo inicial 1 vez por jornada.", Response::HTTP_BAD_REQUEST);

        // $movimientoRegistradora = new Registradora();
        // $movimientoRegistradora->idJornada = $this->idJornada;
        // $movimientoRegistradora->movimiento = $movimientoInicial;
        // $movimientoRegistradora->dinero = $request->dinero;
        // $movimientoRegistradora->idUsuario = auth()->user()->id;
        // $movimientoRegistradora->descripcion = $request->input('descripcion');
        // $movimientoRegistradora->save();
        // dd(MovimientoCajaRegistradora::SALDO_FINAL);
    }
    protected function generarMovimiento(string $movimiento): void
    {
        dd($movimiento);
    }

}