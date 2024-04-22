<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class JwtAuthTest extends TestCase
{
    public function test_registrar_usuario(): void
    {
        Artisan::call('migrate');
        $urlBASE = 'API/auth/registrarUsuario';

        $registroErrorMailIncorrecto = $this->post($urlBASE, ['email' => 'email.incorrecto', 'name' => 'usuario', 'password' => '123456']);
        $registroErrorMailIncorrecto->assertStatus(400)->assertSee(['email', 'valid email']);

        $registroErrorNameRequerido = $this->post($urlBASE, ['email' => 'email@correcto.com', 'password' => '123456']);
        $registroErrorNameRequerido->assertStatus(400)->assertSee(['name', 'required']);

        $registroErrorNameRequerido = $this->post($urlBASE, ['email' => 'email@correcto2.com', 'name' => 'usuario', 'password' => '123']);
        $registroErrorNameRequerido->assertStatus(400)->assertSee(['password', '6']);

        $registroConExito = $this->post($urlBASE, ['email' => 'email@correcto3m.com', 'name' => 'usuario1', 'password' => '1234567']);
        $registroConExito->assertStatus(200)->assertSee(['token', 'usuario']);
    }
}
