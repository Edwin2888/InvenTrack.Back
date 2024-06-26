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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->integer('idTipo');
            $table->string('descripcion', 100);
            $table->integer('estado');
            $table->datetime('fecha');
            $table->foreignId('idVenta')->constrained('ventas')->nullable();
            $table->foreignId('idPedido')->constrained('pedidos')->nullable();
            $table->foreignId('idUsuario')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
