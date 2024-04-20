<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use App\Domain\Producto\IProductoServicio;
use Symfony\Component\HttpFoundation\Response;

class ProductosController extends Controller
{
    protected $productoServicio;
    public function __construct(IProductoServicio $iProductoServicio)
    {
        $this->productoServicio = $iProductoServicio;
    }
    public function obtener(): JsonResponse
    {
        $productos = $this->productoServicio->obtenerTodos();
        return response()->json($productos, 200);
    }

    public function producto(Request $request): JsonResponse
    {
        $requestProducto = $request->only(
            'id',
            'codigo',
            'descripcion',
            'precioSugerido',
            'idCategoria',
            'aplicaStock'
        );
        $this->productoServicio->validarProducto($requestProducto);
        $producto = $this->productoServicio->producto($requestProducto);
        return response()->json($producto, Response::HTTP_OK);
    }
}
