<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ficha', function (Blueprint $table) {
            // Se usa integer() exacto para que coincida con int de MySQL
            $table->integer('codPrograma')->nullable()->after('numFicha');

            // Clave foránea hacia la tabla 'programa'
            $table->foreign('codPrograma')
                  ->references('codPrograma')
                  ->on('programa')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('ficha', function (Blueprint $table) {
            $table->dropForeign(['codPrograma']);
            $table->dropColumn('codPrograma');
        });
    }
};
