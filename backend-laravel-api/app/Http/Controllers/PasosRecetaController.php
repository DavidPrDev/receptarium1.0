<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasosRecetaRequest;
use App\Models\PasosRecetas;
use App\Models\Recetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('validateUser',  $receta, $receta->user);
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

        Gate::authorize('validateUser',  [$paso->recetas, $paso->recetas->user]);

        $paso->update($request->all());

        return response()->json(['message' => 'updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paso = PasosRecetas::find($id);


        if (!$paso) {

            return response()->json(['error' => 'El paso no fue encontrado'], 404);
        }

        Gate::authorize('validateUser',  [$paso->recetas, $paso->recetas->user]);

        $paso->delete();

        return response()->json(['message' => 'deleted'], 204);
    }
}
