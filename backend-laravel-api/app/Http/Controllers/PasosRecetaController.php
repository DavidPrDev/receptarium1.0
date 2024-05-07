<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasosRecetaRequest;
use App\Models\PasosRecetas;
use App\Models\Recetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="Pasos receta Controller",
 *     description="Endpoints related to pasos receta controller"
 * )
 * 
 * @OA\Schema(
 *     schema="PasosRecetaRequest",
 *     @OA\Property(property="titulo", type="string", example="Paso 1"),
 *     @OA\Property(property="descripcion", type="string", example="Descripcion del paso 1"),
 *     @OA\Property(property="recetas_id", type="integer", example=1),
 *     @OA\Property(property="ruta_imagen", type="string", example="Ruta de la imagen , puede ser null"),
 * 
 * )
 */

class PasosRecetaController extends Controller
{


    /**
     * Store a Step
     *
     * @OA\Post(
     *     path="/api/pasos",
     *     summary="Store a step",
     *     tags={"Pasos receta Controller"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Step data",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/PasosRecetaRequest"  
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Step stored",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="ok")
     *          )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error"
     *     )
     * )
     * 
     */

    public function store(PasosRecetaRequest $request)
    {

        $pasos = PasosRecetas::create($request->all());
        return response()->json($pasos);
    }

    /**
     * Show step
     *
     * @OA\Get(
     *     path="/api/pasos/{id}",
     *     summary="Show a step by ID",
     *     tags={"Pasos receta Controller"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of step",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Step found"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     * 
     */
    public function show(string $id)
    {
        $receta = Recetas::find($id);
        Gate::authorize('validateUser',  $receta, $receta->user);
        $pasos = $receta->pasosRecetas;
        return response()->json($pasos);
    }


    /**
     * Update  a step
     *
     * @OA\Put(
     *     path="/api/pasos/{id}",
     *     summary="Update step",
     *     tags={"Pasos receta Controller"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="step data",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/PasosRecetaRequest"  
     *         )
     *     ),
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the step",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Step stored",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="ok")
     *          )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error"
     *     )
     * )
     * 
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
     * Delete a step
     *
     * @OA\Delete(
     *     path="/api/pasos/{id}",
     *     summary="Delete a step by ID",
     *     tags={"Pasos receta Controller"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the step",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=203,
     *         description="Deleted recipe"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     * 
     */
    public function destroy(string $id)
    {
        $paso = PasosRecetas::find($id);


        if (!$paso) {

            return response()->json(['error' => 'El paso no fue encontrado'], 404);
        }

        Gate::authorize('validateUser',  [$paso->recetas, $paso->recetas->user]);

        $paso->delete();

        return response()->json(['message' => 'deleted'], 203);
    }
}
