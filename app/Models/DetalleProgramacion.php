<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProgramacion extends Model
{
    use HasFactory;

    protected $table = 'detalle_programaciones';

    // Relación con Programa
    /* public function programa()
    {
        return $this->belongsTo(Programa::class, 'codPrograma', 'id');
    } */

    // Relación con Actividad de Proyecto
    /* public function actividadProyecto()
    {
        return $this->belongsTo(ActividadProyecto::class, 'idActividadProyecto', 'id');
    } */

    // Relación con Competencia
    /* public function competencia()
    {
        return $this->belongsTo(Competencia::class, 'idCompetencia', 'id');
    } */

    // Relación con Resultado de Aprendizaje
/*     public function resultadoAprendizaje()
    {
        return $this->belongsTo(ResultadoAprendizaje::class, 'idResultadoAprendizaje', 'id');
    } */

    protected $fillable = [
        'idProgramacion',
        'numFicha',
        'codPrograma',
        'idCompetencia',
        'idResultadoAprendizaje',
        'idActividadProyecto',
        'horas',
        'fechaInicio',
        'fechaFin',
    ];

    // Relación inversa con la cabecera
    public function programacion()
    {
        return $this->belongsTo(Programacion::class, 'idProgramacion');
    }

    // Relaciones con las demás tablas complementarias del sistema
    public function programa()
    {
        return $this->belongsTo(Programa::class, 'codPrograma', 'codPrograma');
    }

    public function competencia()
    {
        return $this->belongsTo(Competencia::class, 'idCompetencia');
    }

    public function resultadoAprendizaje()
    {
        return $this->belongsTo(ResultadoAprendizaje::class, 'idResultadoAprendizaje');
    }

    public function actividadProyecto()
    {
        return $this->belongsTo(ActividadProyecto::class, 'idActividadProyecto');
    }
}
