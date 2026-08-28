<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;
class Ficha extends Model
{
    use HasFactory; 
    protected $table = 'ficha'; 
    protected $primaryKey = 'numFicha'; 
    public $incrementing = false; 
    public $timestamps = false; 
    protected $fillable = [
        'numFicha'
    ]; 
}
