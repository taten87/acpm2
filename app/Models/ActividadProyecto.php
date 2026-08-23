<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadProyecto extends Model
{
    use HasFactory;

    protected $table = 'actividadproyecto';
    protected $primaryKey = 'idActividadProyecto';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
    ];
}
