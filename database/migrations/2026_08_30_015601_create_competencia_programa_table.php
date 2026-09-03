<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('competencia_programa', function (Blueprint $table) {
            $table->id();
            
            // Ambas llaves son int (con signo)
            $table->integer('idCompetencia');
            $table->integer('codPrograma');

            // Foreign key hacia 'competencia'
            $table->foreign('idCompetencia')
                ->references('idCompetencia')
                ->on('competencia')
                ->onDelete('cascade');

            // Foreign key hacia 'programa'
            $table->foreign('codPrograma')
                ->references('codPrograma')
                ->on('programa')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('competencia_programa');
    }
};
