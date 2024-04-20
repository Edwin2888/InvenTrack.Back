<?php

namespace App\Enums;

abstract class TipoMovimentoJournada
{
    const SALDO_INICIAL = 'I';
    const PEDIDOS = 'P';
    const GASTOS = 'G';
    const AJUSTES = 'A';
    const SALDO_FINAL = 'F';
}