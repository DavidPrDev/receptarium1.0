<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Receta",
 *     description="Modelo de Receta",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID de la receta"
 *     ),
 *     @OA\Property(
 *         property="titulo",
 *         type="string",
 *         description="Título de la receta"
 *     ),
 *     @OA\Property(
 *         property="ingredientes",
 *         type="string",
 *         description="Ingredientes de la receta"
 *     ),
 *     @OA\Property(
 *         property="tiempo_preparacion",
 *         type="string",
 *         description="Tiempo de preparación de la receta"
 *     ),
 *     @OA\Property(
 *         property="num_personas",
 *         type="integer",
 *         description="Número de personas a las que sirve la receta"
 *     ),
 *     @OA\Property(
 *         property="descripcion",
 *         type="string",
 *         description="Descripción de la receta"
 *     ),
 *     @OA\Property(
 *         property="ruta_imagen_principal",
 *         type="string",
 *         description="Ruta de la imagen principal de la receta"
 *     ),
 *     @OA\Property(
 *         property="categorias_recetas_id",
 *         type="integer",
 *         description="ID de la categoría de la receta"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="ID del usuario que creó la receta"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación de la receta"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de última actualización de la receta"
 *     )
 * )
 */
class Recetas extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'ingredientes',
        'tiempo_preparacion',
        'num_personas',
        'descripcion',
        'ruta_imagen_principal',
        'categorias_recetas_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categoria()
    {
        return $this->belongsTo(CategoriasRecetas::class, 'categorias_recetas_id');
    }

    public function pasosRecetas()
    {
        return $this->hasMany(PasosRecetas::class);
    }
}
