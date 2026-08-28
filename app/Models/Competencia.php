<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Competencia extends Model
{
    use HasFactory;
    protected $table = 'competencia';
    protected $primaryKey = 'idCompetencia';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'numHoras',
    ];
}
