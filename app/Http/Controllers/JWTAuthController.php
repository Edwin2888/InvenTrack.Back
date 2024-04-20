<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class JWTAuthController extends Controller
{

    public function registrarUsuario(Request $request): JsonResponse
    {
        $dataRegistro = $request->only('name', 'email', 'password');

        $validator = Validator::make($dataRegistro, [
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|unique:users||max:50',
            'password' => 'required|string|min:6|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        return response()->json([
            'token' => auth()->attempt($credentials),
            'usuario' => $user
        ], 200);
<<<<<<< HEAD

=======
        
>>>>>>> d3c31fb21ddc52f5d014423982dca2322bd11239
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
<<<<<<< HEAD
        if (!$token = auth()->attempt($validator->validated())) {
=======
        if (! $token = auth()->attempt($validator->validated())) {
>>>>>>> d3c31fb21ddc52f5d014423982dca2322bd11239
            return response()->json('Unauthorized', 401);
        }
        return $this->createNewToken($token);
    }

    public function perfil(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function logout(): JsonResponse
    {
<<<<<<< HEAD
        auth()->logout();
=======
        auth()->logout(true);
>>>>>>> d3c31fb21ddc52f5d014423982dca2322bd11239
        return response()->json('Se ha cerrado la sesión correctamente');
    }

    public function refresh(): JsonResponse
    {
        return $this->createNewToken(auth()->refresh(true, true));
    }

    protected function createNewToken($token): JsonResponse
    {
        return response()->json([
            'token' => $token,
            'tipo_token' => 'bearer',
            'expira_en' => auth()->factory()->getTTL() * 60
        ]);
    }
}
