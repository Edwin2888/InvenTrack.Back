<?php

namespace App\Domain\Producto;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

interface IProductoServicio
{
    public function buscarPorId(int $id): ?Producto;
    public function producto(Request $request): Producto;
    public function eliminar(Producto $producto): void;
    public function obtenerTodos(): Collection;
    public function validarProducto(Request $request): void;

}