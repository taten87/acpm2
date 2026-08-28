<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        // 1. Deshabilitar temporalmente la revisión de llaves foráneas en MySQL
        Schema::disableForeignKeyConstraints();

        // 2. Si la columna estaba en 'programacionmensual', eliminamos la foreign key y la columna
        if (Schema::hasColumn('programacionmensual', 'idActividadProyecto')) {
            Schema::table('programacionmensual', function (Blueprint $table) {
                // Intentamos eliminar la relación
                $table->dropForeign('fk_programacion_actividad');
                $table->dropColumn('idActividadProyecto');
            });
        }

        // 3. Ajustar la tabla 'detalle_programaciones'
        Schema::table('detalle_programaciones', function (Blueprint $table) {
            if (Schema::hasColumn('detalle_programaciones', 'idActividadProyecto')) {
                $table->dropColumn('idActividadProyecto');
            }

            if (!Schema::hasColumn('detalle_programaciones', 'actividad_aprendizaje')) {
                $table->text('actividad_aprendizaje')->nullable()->after('codPrograma');
            }
        });

        // 4. Eliminar la tabla 'actividadproyecto'
        Schema::dropIfExists('actividadproyecto');

        // 5. Volver a habilitar la revisión de llaves foráneas
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('detalle_programaciones', function (Blueprint $table) {
            $table->dropColumn('actividad_aprendizaje');
            $table->unsignedBigInteger('idActividadProyecto')->nullable();
        });

        Schema::enableForeignKeyConstraints();
    }
};
