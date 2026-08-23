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
}
