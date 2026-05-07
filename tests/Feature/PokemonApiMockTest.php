<?php
 
namespace Tests\Feature;
 
use Tests\TestCase;
use App\Models\Pokemon;
use App\Models\Entrenador;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
class PokemonApiMockTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_api_pokemons_con_datos_mockeados_via_factory()
    {
        $entrenador = Entrenador::factory()->create(['nombre' => 'Ash']);
 
        Pokemon::factory()->create(['nombre' => 'Pikachu', 'entrenador_id' => $entrenador->id]);
        Pokemon::factory()->create(['nombre' => 'Charizard', 'entrenador_id' => $entrenador->id]);
 
        $response = $this->getJson('/api/pokemons');
 
        $response->assertStatus(200)
                 ->assertJsonCount(2)
                 ->assertJsonFragment(['nombre' => 'Pikachu'])
                 ->assertJsonFragment(['nombre' => 'Charizard']);
    }
 
    public function test_simulacion_llamada_a_pokeapi_externa()
    {
        Http::fake([
            'pokeapi.co/api/v2/pokemon/1' => Http::response([
                'name' => 'bulbasaur',
                'types' => [['type' => ['name' => 'grass']]]
            ], 200),
        ]);
 
        $response = Http::get('pokeapi.co/api/v2/pokemon/1');
 
        $this->assertTrue($response->ok());
        $this->assertEquals('bulbasaur', $response->json()['name']);
    }
 
    public function test_simulacion_error_de_api_externa()
    {
        Http::fake([
            'pokeapi.co/api/v2/pokemon/9999' => Http::response(
                ['error' => 'Not Found'], 404
            ),
        ]);
 
        $response = Http::get('pokeapi.co/api/v2/pokemon/9999');
 
        $this->assertEquals(404, $response->status());
    }
}
