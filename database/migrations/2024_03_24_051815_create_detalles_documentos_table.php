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
        Schema::create('detalles_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idDocumento')->constrained('documentos');
            $table->foreignId('idProducto')->constrained('productos');
            $table->decimal('cantidad', 12, 2);
            $table->foreignId('idUsuario')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_documentos');
    }
};
