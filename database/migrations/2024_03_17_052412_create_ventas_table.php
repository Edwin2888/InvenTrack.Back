<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 255);
            $table->string('estado', 1);
            $table->foreignId('idUsuario')->constrained('users');
            $table->foreignId('idCliente')->constrained('clientes')->nullable();
            $table->foreignId('idJornada')->constrained('jornadas');
            $table->decimal('dineroPagado', 12, 2)->nullable();
            $table->string('tipoPago', 1)->nullable();
            $table->string('codigoTransaccion', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
