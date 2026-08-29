<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ResultadoAprendizaje extends Model
{
    use HasFactory;
    protected $table = 'resultadoaprendizaje';
    protected $primaryKey = 'idResultadoAprendizaje';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'horas',
    ];
}
