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
        Schema::create('pagos_ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('idVenta');
            $table->decimal('dinero', 12, 2);
            $table->string('tipo', 1);
            $table->string('codigoTransaccion', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_ventas');
    }
};
