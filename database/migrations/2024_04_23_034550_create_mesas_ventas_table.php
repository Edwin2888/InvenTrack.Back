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
        Schema::create('mesas_ventas', function (Blueprint $table) {
            $table->foreignId('idVenta')->constrained('ventas');
            $table->foreignId('idMesa')->constrained('mesas');
            $table->foreignId('idUsuario')->constrained('users');
            $table->timestamps();

            $table->primary(['idMesa', 'idVenta']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesas_ventas');
    }
};
