<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyJwtToken;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\JornadaController;
use App\Http\Controllers\RegistradoraController;

Route::prefix('auth')->group(function () {
    Route::middleware([VerifyJwtToken::class])->group(function () {
        Route::post('logout', [JWTAuthController::class, 'logout']);
        Route::post('refresh', [JWTAuthController::class, 'refresh']);
        Route::get('perfil', [JWTAuthController::class, 'perfil']);
    });
    Route::withoutMiddleware([VerifyJwtToken::class])->group(function () {
        Route::post('registrarUsuario', [JWTAuthController::class, 'registrarUsuario']);
        Route::post('login', [JWTAuthController::class, 'login']);
    });
});

Route::middleware([VerifyJwtToken::class])->group(function () {
    Route::prefix('productos')->group(function () {
        Route::get('/', [ProductosController::class, 'obtener']);
        Route::post('/', [ProductosController::class, 'producto']);
    });

    Route::prefix('jornada')->group(function () {
        Route::get('/', [JornadaController::class, 'jornadaActual']);
        Route::post('/iniciarJornada', [JornadaController::class, 'iniciarJornada']);
        Route::post('/cerrarJornada', [JornadaController::class, 'cerrarJornada']);
    });

    Route::prefix('registradora')->group(function () {
        Route::post('/nuevoMovimiento', [RegistradoraController::class, 'movimiento']);
    });
});

Route::fallback(function () {
    return response()->json('Url no encontrada', 404);
});
