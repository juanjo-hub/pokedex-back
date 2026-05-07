<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Entrenador extends Model
{
    use HasFactory;
    protected $table = 'entrenadores';
    protected $fillable = ['nombre', 'ciudad', 'edad'];
 
    public function pokemons() {
        return $this->hasMany(Pokemon::class, 'entrenador_id');
    }
}
