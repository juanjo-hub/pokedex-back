<?php
 
namespace Tests\Unit;
 
use Tests\TestCase;
use App\Models\Pokemon;
use App\Models\Entrenador;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
class PokemonModelTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_pokemon_tiene_campos_fillable_correctos()
    {
        $pokemon = new Pokemon();
 
        $this->assertEquals(
            ['nombre', 'tipo', 'nivel', 'entrenador_id'],
            $pokemon->getFillable()
        );
    }
 
    public function test_pokemon_pertenece_a_un_entrenador()
    {
        $entrenador = Entrenador::factory()->create(['nombre' => 'Ash']);
 
        $pokemon = Pokemon::factory()->create([
            'nombre' => 'Pikachu',
            'entrenador_id' => $entrenador->id,
        ]);
 
        $this->assertInstanceOf(Entrenador::class, $pokemon->entrenador);
        $this->assertEquals('Ash', $pokemon->entrenador->nombre);
    }
 
    public function test_entrenador_tiene_muchos_pokemons()
    {
        $entrenador = Entrenador::factory()->create();
        Pokemon::factory()->count(3)->create(['entrenador_id' => $entrenador->id]);
 
        $this->assertCount(3, $entrenador->pokemons);
    }
 
    public function test_pokemon_se_crea_con_factory()
    {
        $pokemon = Pokemon::factory()->create();
 
        $this->assertDatabaseHas('pokemons', ['id' => $pokemon->id]);
    }
 
    public function test_eliminar_entrenador_elimina_pokemons_en_cascada()
    {
        $entrenador = Entrenador::factory()->create();
        $pokemon = Pokemon::factory()->create(['entrenador_id' => $entrenador->id]);
 
        $entrenador->delete();
 
        $this->assertDatabaseMissing('pokemons', ['id' => $pokemon->id]);
    }
}
