<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('competencia', function (Blueprint $table) {
            // Se usa integer para coincidir exactamente con el int PK de la tabla programa
            $table->integer('codPrograma')->nullable()->after('idCompetencia');

            // Clave foránea hacia la tabla 'programa'
            $table->foreign('codPrograma')
                ->references('codPrograma')
                ->on('programa')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('competencia', function (Blueprint $table) {
            $table->dropForeign(['codPrograma']);
            $table->dropColumn('codPrograma');
        });
    }
};
