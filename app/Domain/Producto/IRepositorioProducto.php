<?php

namespace App\Domain\Producto;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Collection;

interface IRepositorioProducto
{
    public function buscarPorId(int $id): ?Producto;
    public function nuevo(Producto $producto): Producto;
    public function eliminar(Producto $producto): void;
    public function obtenerTodos(): Collection;

}