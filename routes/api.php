<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyJwtToken;
use App\Http\Controllers\JWTAuthController;

Route::prefix('auth')->group(function () {
    Route::middleware([VerifyJwtToken::class])->group(function () {
        Route::post('logout', [JWTAuthController::class, 'logout']);
        Route::post('refresh', [JWTAuthController::class, 'refresh']);
        Route::get('profile', [JWTAuthController::class, 'profile']);
        Route::get('string', [JWTAuthController::class, 'string']);
    });
    Route::withoutMiddleware([VerifyJwtToken::class])->group(function () {
        Route::post('registrarUsuario', [JWTAuthController::class, 'registrarUsuario']);
        Route::post('login', [JWTAuthController::class, 'login']);
    });
});
