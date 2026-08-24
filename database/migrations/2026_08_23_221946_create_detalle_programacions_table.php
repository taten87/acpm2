<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detalle_programaciones', function (Blueprint $table) {
            $table->id();

            // Clave foránea que enlaza con la tabla padre 'programaciones'
            $table->foreignId('idProgramacion')
                ->constrained('programaciones')
                ->onDelete('cascade');

            // Campos del bloque de clase
            $table->string('numFicha');
            $table->string('codPrograma');
            $table->foreignId('idCompetencia');
            $table->foreignId('idResultadoAprendizaje');
            $table->foreignId('idActividadProyecto');
            $table->integer('horas');
            $table->date('fechaInicio');
            $table->date('fechaFin');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_programaciones');
    }
};
