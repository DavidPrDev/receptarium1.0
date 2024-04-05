<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecetaRequest;
use App\Models\Recetas;
use Illuminate\Http\Request;


class RecetaController extends Controller
{

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
