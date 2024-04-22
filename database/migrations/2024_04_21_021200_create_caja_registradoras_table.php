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
            $table->integer('idJornada');
            $table->string('movimiento', '1');
            $table->decimal('dinero', 12, 2);
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
        Schema::dropIfExists('registradoras');
    }
};
