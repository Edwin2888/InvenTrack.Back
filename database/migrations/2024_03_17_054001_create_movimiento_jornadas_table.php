<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimiento_jornadas', function (Blueprint $table) {
            $table->id();
            $table->integer('idJornada');
            $table->integer('tipo');
            $table->double('dinero', 12,2);
            $table->integer('idUsuario');
            $table->string('descripcion', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_jornadas');
    }
};
