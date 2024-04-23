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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 255);
            $table->string('codigoFactura', 255)->nullable();
            $table->decimal('dinero', 12, 2);
            $table->boolean('estado');
            $table->foreignId('idJornada')->constrained('jornadas');
            $table->foreignId('idCategoria')->constrained('categorias')->nullable();
            $table->foreignId('idUsuario')->constrained('users');
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
