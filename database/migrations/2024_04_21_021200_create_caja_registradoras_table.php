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
        Schema::create('registradoras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idJornada')->constrained('jornadas');
            $table->string('movimiento', 1);
            $table->decimal('dinero', 12, 2);
            $table->foreignId('idUsuario')->constrained('users');
            $table->string('descripcion', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registradoras');
    }
};
