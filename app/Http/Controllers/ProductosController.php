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
        $this->productoServicio->validarProducto($request);
        $producto = $this->productoServicio->producto($request);
        return response()->json($producto, Response::HTTP_OK);
    }
}
