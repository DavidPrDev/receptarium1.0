<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecetaRequest;
use App\Models\Recetas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

/**
 * @OA\Tag(
 *     name="Receta Controller",
 *     description="Endpoints related to recipe controller"
 * )
 * 
 * @OA\Schema(
 *     schema="RecetaRequest",
 *     @OA\Property(property="titulo", type="string", example="Test receta"),
 *     @OA\Property(property="ingredientes", type="string", example="ingrediente 1, ingrediente 2"),
 *     @OA\Property(property="tiempo_preparacion", type="string", example="20 m"),
 *     @OA\Property(property="num_personas", type="integer", example=1),
 *     @OA\Property(property="descripcion", type="string", example="Descripcion de la receta"),
 *     @OA\Property(property="categorias_recetas_id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1)
 * )
 */


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
    /**
     * Show a recipes in categories
     *
     * @OA\Get(
     *     path="/api/recetas-categoria/{id}",
     *     summary="Show a recipe in categori",
     *     tags={"Receta Controller"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the recipe",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description=" recipes in categories"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     * 
     */
    public function recetasEnCategoria(Request $request, $categoria_id)
    {
        if (!$categoria_id) {
            return response()->json(['error' => 'El parámetro categoria_id es obligatorio.'], 400);
        }

        $recetas = $request->user()->recetas()->where('categorias_recetas_id', $categoria_id)->get();

        return response()->json($recetas, 200);
    }
    /**
     * Store a recipe
     *
     * @OA\Post(
     *     path="/api/receta",
     *     summary="Store a recipe",
     *     tags={"Receta Controller"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Recipe data",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/RecetaRequest"  
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recipe stored",
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
     * Show a recipe
     *
     * @OA\Get(
     *     path="/api/receta/{id}",
     *     summary="Show a recipe by ID",
     *     tags={"Receta Controller"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the recipe",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Recipe found"
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

        if (!$receta) {

            return response()->json(['error' => 'La receta no fue encontrado'], 404);
        }

        return response()->json($receta);
    }

    /**
     * Update  recipe
     *
     * @OA\Put(
     *     path="/api/receta/{id}",
     *     summary="Update recipe",
     *     tags={"Receta Controller"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Recipe data",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/RecetaRequest"  
     *         )
     *     ),
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the recipe",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recipe stored",
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

    public function update(RecetaRequest $request, string $id)
    {
        $receta = Recetas::find($id);
        Gate::authorize('validateUser',  $receta, $receta->user);
        $receta->update($request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'Receta actualizada exitosamente'
        ]);
    }

    /**
     * Delete a recipe
     *
     * @OA\Delete(
     *     path="/api/receta/{id}",
     *     summary="Delete a recipe by ID",
     *     tags={"Receta Controller"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the recipe",
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
        $receta = Recetas::find($id);

        Gate::authorize('validateUser',  $receta, $receta->user);

        $receta->delete();

        return response()->json([
            'status' => 'ok',
            'message' => "Receta eliminada"
        ], 203);
    }
}
