<?php

namespace App\Domain\Producto;

use App\Models\Producto;
use App\Http\Requests\ProductoRequest;
use Illuminate\Database\Eloquent\Collection;

interface IProductoServicio
{
    public function buscarPorId(int $id): ?Producto;
    public function producto(ProductoRequest $request): Producto;
    public function eliminar(Producto $producto): void;
    public function obtenerTodos(): Collection;

}