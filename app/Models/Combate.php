<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Combate extends Model
{
    use HasFactory;
    protected $table = 'combates';
    protected $fillable = ['pokemon_local_id', 'pokemon_visitante_id', 'fecha', 'resultado'];
 
    public function pokemonLocal() {
        return $this->belongsTo(Pokemon::class, 'pokemon_local_id');
    }
    public function pokemonVisitante() {
        return $this->belongsTo(Pokemon::class, 'pokemon_visitante_id');
    }
}
