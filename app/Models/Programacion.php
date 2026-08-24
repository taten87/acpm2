<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    use HasFactory;

    // Apuntamos a la tabla correcta
    protected $table = 'programaciones';

    // Como la migración creó la tabla con $table->id(), la clave primaria es 'id'
    protected $primaryKey = 'id';

    protected $fillable = [
        'idUsuario',
        'mes_anio',
    ];

    // Relación con los detalles
    // Apuntamos a DetalleProgramacion
    public function detalles()
    {
        return $this->hasMany(DetalleProgramacion::class, 'idProgramacion');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }
}