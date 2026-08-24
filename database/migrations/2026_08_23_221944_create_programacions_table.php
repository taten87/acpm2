<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('programaciones', function (Blueprint $table) {
            $table->id();

            // Relación con el instructor/usuario
            $table->foreignId('idUsuario')
                ->constrained('users')
                ->onDelete('cascade');

            // Mes y año programado (ej: "2026-08")
            $table->string('mes_anio', 7);

            $table->timestamps();

            // Garantiza que un instructor no duplique fichas en el mismo mes
            $table->unique(['idUsuario', 'mes_anio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programaciones');
    }
};