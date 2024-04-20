<?php

namespace App\Domain\Producto;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Collection;

interface IProductoServicio
{
    public function buscarPorId(int $id): ?Producto;
    public function producto(array $data): Producto;
    public function eliminar(Producto $producto): void;
    public function obtenerTodos(): Collection;
    public function validarProducto(array $data): void;

}