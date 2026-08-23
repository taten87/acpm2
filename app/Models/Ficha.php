<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    use HasFactory;

    protected $table = 'ficha';
    protected $primaryKey = 'numFicha';
    public $incrementing = false; // Como numFicha lo ingresa el usuario, no es autoincremental

    // Desactiva la búsqueda automática de created_at y updated_at
    public $timestamps = false;

    protected $fillable = [
        'numFicha',
    ];
}
