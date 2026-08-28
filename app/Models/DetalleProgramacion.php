<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class DetalleProgramacion extends Model
{
    use HasFactory;
    protected $table = 'detalle_programaciones';
    protected $fillable = [
        'idProgramacion',
        'numFicha',
        'codPrograma',
        'idCompetencia',
        'idResultadoAprendizaje',
        'actividad_aprendizaje',
        'horas',
        'fechaInicio',
        'fechaFin',
    ];
    public function programacion()
    {
        return $this->belongsTo(Programacion::class, 'idProgramacion');
    }
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
}
