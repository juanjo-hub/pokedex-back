<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Pokemon;
 
class PokemonController extends Controller
{
    public function index() {
        return Pokemon::with('entrenador')->get();
    }
    public function store(Request $request) {
        $datos = $request->validate([
            'nombre'        => 'required|min:2',
            'tipo'          => 'required',
            'nivel'         => 'required|integer|min:1|max:100',
            'entrenador_id' => 'required|exists:entrenadores,id',
        ]);
        return response()->json(Pokemon::create($datos), 201);
    }
    public function show(string $id) {
        return Pokemon::with('entrenador')->findOrFail($id);
    }
    public function update(Request $request, string $id) {
        $p = Pokemon::findOrFail($id);
        $p->update($request->validate([
            'nombre'        => 'sometimes|min:2',
            'tipo'          => 'sometimes',
            'nivel'         => 'sometimes|integer|min:1|max:100',
            'entrenador_id' => 'sometimes|exists:entrenadores,id',
        ]));
        return $p;
    }
    public function destroy(string $id) {
        Pokemon::findOrFail($id)->delete();
        return response()->json(['mensaje' => 'Eliminado']);
    }
}
