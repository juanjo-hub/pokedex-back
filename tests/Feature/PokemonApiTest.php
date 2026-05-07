<?php
 
namespace Tests\Feature;
 
use Tests\TestCase;
use App\Models\Pokemon;
use App\Models\Entrenador;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
class PokemonApiTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_api_devuelve_lista_de_pokemons()
    {
        $entrenador = Entrenador::factory()->create();
        Pokemon::factory()->create([
            'nombre' => 'Pikachu',
            'tipo' => 'electrico',
            'nivel' => 25,
            'entrenador_id' => $entrenador->id,
        ]);
 
        $response = $this->getJson('/api/pokemons');
 
        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => 'Pikachu']);
    }
 
    public function test_api_devuelve_pokemon_con_su_entrenador()
    {
        $entrenador = Entrenador::factory()->create(['nombre' => 'Ash']);
        Pokemon::factory()->create([
            'nombre' => 'Charizard',
            'entrenador_id' => $entrenador->id,
        ]);
 
        $response = $this->getJson('/api/pokemons');
 
        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => 'Ash']);
    }
 
    public function test_api_devuelve_pokemon_por_id()
    {
        $entrenador = Entrenador::factory()->create();
        $pokemon = Pokemon::factory()->create([
            'nombre' => 'Bulbasaur',
            'entrenador_id' => $entrenador->id,
        ]);
 
        $response = $this->getJson("/api/pokemons/{$pokemon->id}");
 
        $response->assertStatus(200)
                 ->assertJsonFragment(['nombre' => 'Bulbasaur']);
    }
 
    public function test_api_devuelve_404_si_pokemon_no_existe()
    {
        $response = $this->getJson('/api/pokemons/999');
        $response->assertStatus(404);
    }
 
    public function test_se_puede_crear_pokemon_via_api()
    {
        $entrenador = Entrenador::factory()->create();
 
        $response = $this->postJson('/api/pokemons', [
            'nombre'        => 'Mewtwo',
            'tipo'          => 'psiquico',
            'nivel'         => 70,
            'entrenador_id' => $entrenador->id,
        ]);
 
        $response->assertStatus(201);
        $this->assertDatabaseHas('pokemons', ['nombre' => 'Mewtwo', 'nivel' => 70]);
    }
 
    public function test_validacion_falla_con_datos_incorrectos()
    {
        $entrenador = Entrenador::factory()->create();
 
        $response = $this->postJson('/api/pokemons', [
            'nombre' => '',
            'tipo'   => 'fuego',
            'nivel'  => 200,
            'entrenador_id' => $entrenador->id,
        ]);
 
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre', 'nivel']);
    }
 
    public function test_se_puede_eliminar_pokemon_via_api()
    {
        $pokemon = Pokemon::factory()->create();
 
        $response = $this->deleteJson("/api/pokemons/{$pokemon->id}");
 
        $response->assertStatus(200);
        $this->assertDatabaseMissing('pokemons', ['id' => $pokemon->id]);
    }
}
