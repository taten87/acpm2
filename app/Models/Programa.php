<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Programa extends Model
{
    use HasFactory;
    protected $table = 'programa';
    protected $primaryKey = 'codPrograma';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'version',
    ];

    public function competencias()
    {
        return $this->belongsToMany(
            Competencia::class,
            'competencia_programa', // Tabla pivote
            'codPrograma',          // FK de este modelo en la pivote
            'idCompetencia'         // FK del modelo relacionado en la pivote
        );
    }
}
