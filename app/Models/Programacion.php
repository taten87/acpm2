<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Programacion extends Model
{
    use HasFactory;
    protected $table = 'programaciones';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idUsuario',
        'mes_anio',
    ];
    public function detalles()
    {
        return $this->hasMany(DetalleProgramacion::class, 'idProgramacion', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }
}