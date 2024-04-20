<?php

namespace App\Domain\Producto;

use Validator;
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

    public function producto(array $data): Producto
    {
        try {
            $producto = (isset($data["id"])) ?
                $this->actualizar($data) :
                $this->nuevo($data);
            return $producto;
        } catch (\Throwable $th) {
            throw new InvenTrackException($th->getMessage(), 400);
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
    public function validarProducto(array $data): void
    {
        $validator = Validator::make($data, [
            'codigo' => 'required|string|between:3,100|unique:productos,codigo,' . ($data['id'] ?? ''),
            'descripcion' => 'required|string|between:3,100',
            'precioSugerido' => 'numeric',
            'idCategoria' => 'numeric',
            'aplicaStock' => 'required|boolean',
        ]);


        if ($validator->fails())
            throw new InvenTrackException($validator->errors()->all(), Response::HTTP_BAD_REQUEST);
        return;

    }

    private function nuevo(array $data): Producto
    {
        $producto = new Producto();
        $producto->codigo = $data['codigo'];
        $producto->descripcion = $data['descripcion'];
        $producto->precioSugerido = $data['precioSugerido'] ?? 0;
        $producto->idCategoria = $data['idCategoria'] ?? null;
        $producto->aplicaStock = $data['aplicaStock'];

        $producto->save();
        return $producto;
    }

    private function actualizar(array $data): Producto
    {
        $producto = Producto::find($data['id']);
        if (!$producto)
            throw new InvenTrackException("El producto no existe.", Response::HTTP_NOT_FOUND);

        $producto->codigo = $data['codigo'];
        $producto->descripcion = $data['descripcion'];
        $producto->precioSugerido = $data['precioSugerido'] ?? 0;
        $producto->idCategoria = $data['idCategoria'] ?? null;
        $producto->aplicaStock = $data['aplicaStock'];

        $producto->save();
        return $producto;
    }
}