<?php

namespace App\Models; // Con esto se puede llamar por que es la forma de decirle donde se pueden encontrar los archivos

use Illuminate\Database\Eloquent\Factories\HasFactory; // Librería para los datos de prueba
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    use HasFactory; // Esto es para poder usar datos de prueba

    protected $table = 'ficha'; // Le estamos diciendo a Eloquent que la tabla se llama ficha y no fichas
    protected $primaryKey = 'numFicha'; // Le estamos diciendo a Eloquent que la clave primaria es numFicha y no id
    public $incrementing = false; // Como numFicha lo ingresa el usuario, no es autoincremental

    // Desactiva la búsqueda automática de created_at y updated_at
    public $timestamps = false; // fecha de creación y demas para poder desactivar esos campos que no se van a usar

    protected $fillable = [
        'numFicha'
    ]; // Aca estamos dando el permiso para que se puedan guardar datos en los campo llamados dentro de $fillable
}
