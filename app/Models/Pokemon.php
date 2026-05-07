<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Pokemon extends Model
{
    use HasFactory;
    protected $table = 'pokemons';
    protected $fillable = ['nombre', 'tipo', 'nivel', 'entrenador_id'];
 
    public function entrenador() {
        return $this->belongsTo(Entrenador::class, 'entrenador_id');
    }
}
