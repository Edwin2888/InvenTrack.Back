<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Producto;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class ProductosController extends Controller
{
    public function obtener(): JsonResponse
    {
        $productos = Producto::get();
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

        $validator = Validator::make($requestProducto, [
            'codigo' => 'required|string|between:3,100|unique:productos,codigo,' . $request->id,
            'descripcion' => 'required|string|between:3,100',
            'precioSugerido' => 'numeric',
            'idCategoria' => 'numeric',
            'aplicaStock' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $id = $requestProducto['id'];

        if (is_null($id)) {
            $nuevoProducto = Producto::create($requestProducto);
            return response()->json($nuevoProducto, 201);
        } else {
            $producto = Producto::find($id);
            if (!$producto) {
                return response()->json(['error' => 'El producto no existe.'], 404);
            }
            $producto->update($requestProducto);
            return response()->json($producto, 200);
        }
    }
}
