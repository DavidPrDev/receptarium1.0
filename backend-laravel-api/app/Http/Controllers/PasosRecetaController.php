<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasosRecetaRequest;
use App\Models\PasosRecetas;
use App\Models\Recetas;
use Illuminate\Http\Request;

class PasosRecetaController extends Controller
{

    public function store(PasosRecetaRequest $request)
    {

        $pasos = PasosRecetas::create($request->all());
        return response()->json($pasos);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $receta = Recetas::find($id);
        $pasos = $receta->pasosRecetas;
        return response()->json($pasos);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PasosRecetaRequest $request, string $id)
    {
        $paso = PasosRecetas::find($id);

        if (!$paso) {

            return response()->json(['error' => 'El paso no fue encontrado'], 404);
        }

        $paso->update($request->all());

        return response()->json(['message' => 'updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paso = PasosRecetas::find($id)->delete();

        if (!$paso) {

            return response()->json(['error' => 'El paso no fue encontrado'], 404);
        }

        return response()->json(['message' => 'deleted'], 204);
    }
}
