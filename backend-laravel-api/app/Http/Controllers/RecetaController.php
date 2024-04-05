<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecetaRequest;
use App\Models\Recetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecetaController extends Controller
{

    public function countRecetas(Request $request)
    {
        $user = $request->user();

        $recetasPorCategoria = $user->recetas()
            ->with('categoria:id,nombre')
            ->select('categorias_recetas_id', DB::raw('COUNT(*) as cantidad_recetas'))
            ->groupBy('categorias_recetas_id')
            ->get();

        $formattedResults = $recetasPorCategoria->map(function ($item) {
            return [
                'categoria_id' => $item->categoria->id,
                'nombre_categoria' => $item->categoria->nombre,
                'cantidad_recetas' => $item->cantidad_recetas,
            ];
        });

        return response()->json($formattedResults, 200);
    }
    public function recetasEnCategoria(Request $request, $categoria_id)
    {
        if (!$categoria_id) {
            return response()->json(['error' => 'El parámetro categoria_id es obligatorio.'], 400);
        }

        $recetas = $request->user()->recetas()->where('categorias_recetas_id', $categoria_id)->get();

        return response()->json($recetas, 200);
    }

    public function store(RecetaRequest $request)
    {
        $usuario = $request->user();

        $nuevaReceta = Recetas::create([
            'titulo' => $request->titulo,
            'ingredientes' => $request->ingredientes,
            'tiempo_preparacion' => $request->tiempo_preparacion,
            'num_personas' => $request->num_personas,
            'descripcion' => $request->descripcion,
            'user_id' => $usuario->id,
            'categorias_recetas_id' => $request->categorias_recetas_id,
        ]);
        return response()->json([
            'status' => "ok",
            'id_receta' => $nuevaReceta->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $receta = Recetas::find($id);

        if (!$receta) {

            return response()->json(['error' => 'La receta no fue encontrado'], 404);
        }

        return response()->json($receta);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(RecetaRequest $request, string $id)
    {
        $receta = Recetas::find($id);

        $receta->update($request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'Receta actualizada exitosamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Recetas::find($id)->delete();

        return response()->json([
            'status' => 'ok',
            'message' => "Receta eliminada"
        ], 200);
    }
}
