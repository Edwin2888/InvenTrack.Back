<?php

namespace App\Enums;

abstract class MovimientoCajaRegistradora
{
    const SALDO_INICIAL = 'I';
    const VENTAS = 'V';
    const PEDIDOS = 'P';
    const GASTOS = 'G';
    const AJUSTES = 'A';
    const DEUDAS = 'D';
    const SALDO_FINAL = 'F';
}