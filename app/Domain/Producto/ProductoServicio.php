<?php

namespace App\Domain\Producto;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Exceptions\InvenTrackException;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;


class ProductoServicio implements IProductoServicio
{

    public function buscarPorId(int $id): ?Producto
    {
        return Producto::find($id);
    }

    public function producto(Request $request): Producto
    {
        try {
            $producto = (isset($request->id)) ?
                $this->actualizar($request->all()) :
                $this->nuevo($request->all());
            return $producto;
        } catch (\Throwable $th) {
            throw new InvenTrackException($th->getMessage(), $th->getCode(), $th);
        }
    }

    public function eliminar(Producto $producto): void
    {
        $producto->delete();
    }

    public function obtenerTodos(): Collection
    {
        return Producto::all();
    }
    public function validarProducto(Request $request): void
    {
        $request->validate([
            'codigo' => 'required|string|between:3,100|unique:productos,codigo,' . $request->id,
            'descripcion' => 'required|string|between:3,100',
            'precioSugerido' => 'numeric',
            'idCategoria' => 'numeric',
            'aplicaStock' => 'required|boolean',
        ]);
        return;

    }

    private function nuevo(array $data): Producto
    {
        $producto = Producto::create($data);
        return $producto;
    }

    private function actualizar(array $data): Producto
    {
        $producto = Producto::find($data['id']);
        if (!$producto)
            throw new InvenTrackException("El producto no existe.", Response::HTTP_NOT_FOUND);

        $producto->update($data);

        return $producto;
    }
}