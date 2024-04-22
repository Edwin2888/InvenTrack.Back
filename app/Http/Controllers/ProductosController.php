<?php

namespace App\Http\Controllers;

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

    // public function eliminar($id): JsonResponse
    // {
    //     $producto = Producto::find($id);
    //     if ($producto) {
    //         $producto->delete();
    //         return response()->json('Producto eliminado exitosamente', 200);
    //     }
    //     return response()->json('El producto no existe', 404);
    // }
}
