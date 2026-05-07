<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Entrenador;
 
class EntrenadorController extends Controller
{
    public function index() {
        return Entrenador::with('pokemons')->get();
    }
    public function store(Request $request) {
        $datos = $request->validate([
            'nombre' => 'required|min:2',
            'ciudad' => 'required',
            'edad'   => 'required|integer|min:1',
        ]);
        return response()->json(Entrenador::create($datos), 201);
    }
    public function show(string $id) {
        return Entrenador::with('pokemons')->findOrFail($id);
    }
    public function update(Request $request, string $id) {
        $e = Entrenador::findOrFail($id);
        $e->update($request->validate([
            'nombre' => 'sometimes|min:2',
            'ciudad' => 'sometimes',
            'edad'   => 'sometimes|integer|min:1',
        ]));
        return $e;
    }
    public function destroy(string $id) {
        Entrenador::findOrFail($id)->delete();
        return response()->json(['mensaje' => 'Eliminado']);
    }
}
