<?php

namespace App\Domain\Producto;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Collection;

class RepositorioProducto implements IRepositorioProducto
{
    public function buscarPorId(int $id): ?Producto
    {
        return Producto::find($id);
    }

    public function nuevo(Producto $producto): Producto
    {
        $producto->save();
        return $producto;
    }

    public function eliminar(Producto $producto): void
    {
        $producto->delete();
    }

    public function obtenerTodos(): Collection
    {
        return Producto::all();
    }
}