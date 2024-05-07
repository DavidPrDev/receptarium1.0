<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Pasos_recetas",
 *     description="Modelo de Pasos_recetas",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID de la receta"
 *     ),
 *     @OA\Property(
 *         property="titulo",
 *         type="string",
 *         description="Título del paso"
 *     ),
 *  @OA\Property(
 *         property="descripcion",
 *         type="string",
 *         description="descripcion del paso"
 *     ),
 *  @OA\Property(
 *         property="ruta_imagen",
 *         type="string",
 *         description="ruta de la imagen del paso"
 *     ),
 * @OA\Property(
 *         property="recetas_id",
 *          type="integer",
 *         description="ID de la receta."
 *     ),
 *)  
 */
class PasosRecetas extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'ruta_imagen',
        'recetas_id'
    ];

    public function recetas()
    {
        return $this->belongsTo(Recetas::class, 'recetas_id');
    }
}
