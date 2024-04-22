<?php

namespace App\Domain\Producto;

use App\Models\Producto;
use App\Http\Requests\ProductoRequest;
use App\Exceptions\InvenTrackException;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;


class ProductoServicio implements IProductoServicio
{

    public function buscarPorId(int $id): ?Producto
    {
        return Producto::find($id);
    }

    public function producto(ProductoRequest $request): Producto
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

    public function eliminar(int $id): void
    {
        $producto = Producto::find($id);
        if (!$producto)
            throw new InvenTrackException("El producto no existe", Response::HTTP_NOT_FOUND);

        $producto->delete();
    }

    public function obtenerTodos(): Collection
    {
        return Producto::all();
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