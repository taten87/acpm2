<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramacionMensual extends Model
{
    use HasFactory;

    protected $table = 'programacionmensual';
    protected $primaryKey = 'idProgramacionMensual';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'idUsuario',
        'numFicha',
        'codPrograma',
        'idCompetencia',
        'idResultadoAprendizaje',
        'idActividadProyecto',
        'horas',
        'fechaInicio',
        'fechaFin',
    ];

    // Relaciones Eloquent
    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario', 'id');
    }

    public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'numFicha', 'numFicha');
    }

    public function programa()
    {
        return $this->belongsTo(Programa::class, 'codPrograma', 'codPrograma');
    }

    public function competencia()
    {
        return $this->belongsTo(Competencia::class, 'idCompetencia', 'idCompetencia');
    }

    public function resultadoAprendizaje()
    {
        return $this->belongsTo(ResultadoAprendizaje::class, 'idResultadoAprendizaje', 'idResultadoAprendizaje');
    }

    public function actividadProyecto()
    {
        return $this->belongsTo(ActividadProyecto::class, 'idActividadProyecto', 'idActividadProyecto');
    }
}
