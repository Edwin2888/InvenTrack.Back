<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use \Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductoRequest;
use App\Domain\Producto\IProductoServicio;
use Symfony\Component\HttpFoundation\Response;

class ProductosController extends Controller
{
    protected IProductoServicio $productoServicio;
    public function __construct(IProductoServicio $iProductoServicio)
    {
        $this->productoServicio = $iProductoServicio;
    }
    public function obtener(): JsonResponse
    {
        $productos = $this->productoServicio->obtenerTodos();
        return new JsonResponse($productos, Response::HTTP_OK);
    }

    public function producto(ProductoRequest $request): JsonResponse
    {
        $producto = $this->productoServicio->producto($request);
        return new JsonResponse($producto, Response::HTTP_OK);
    }

    public function eliminar(int $id): void
    {
        $this->productoServicio->eliminar($id);
    }
}
