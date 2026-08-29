<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('resultadoaprendizaje', function (Blueprint $table) {
            // Se define el campo horas. Se puede agregar nullable() si hay registros antiguos sin este valor.
            $table->unsignedSmallInteger('horas')->nullable()->after('nombre');
        });
    }
    
    public function down(): void
    {
        Schema::table('resultadoaprendizaje', function (Blueprint $table) {
            $table->dropColumn('horas');
        });
    }
};
