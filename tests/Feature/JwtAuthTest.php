<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class JwtAuthTest extends TestCase
{
    public function test_registrar(): void {
        // Artisan::call('migrate');
        $registroErrorMailIncorrecto = $this->post('api/auth/registrarUsuario', ['email' => 'dsa', 'name' => 'edwin', 'password' => '123456']);
        $registroErrorMailIncorrecto->assertStatus(400)->assertSee(['email', 'valid email']);

        $registroErrorNameRequerido = $this->post('api/auth/registrarUsuario', ['email' => 'email@correcto.com', 'password' => '123456']);
        $registroErrorNameRequerido->assertStatus(400)->assertSee(['name', 'required']);

        $registroErrorNameRequerido = $this->post('api/auth/registrarUsuario', ['email' => 'email@correcto2.com', 'name' => 'edwin', 'password' => '123']);
        $registroErrorNameRequerido->assertStatus(400)->assertSee(['password', '6']);

        $registroConExito = $this->post('api/auth/registrarUsuario', ['email' => 'email@correcto3.com', 'name' => 'edwin', 'password' => '1234567']);
        $registroConExito->assertStatus(200)->assertSee(['token', 'usuario']);
    }
}
