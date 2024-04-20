<?php

namespace App\Enums;

abstract class TipoDocumento
{
    const VENTAS = 'V';
    const PEDIDOS = 'P';
    const AJUSTE_INVENTARIO = 'AI';
    const AJUSTE_DIFERENCIAS = 'AD';
}