<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Categoria_recetas",
 *     description="Modelo de categoria_recetas",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID de la categoria"
 *     ),
 *     @OA\Property(
 *         property="nombre",
 *         type="string",
 *         description="Nombre de la categoria"
 *     )
 * )
 */
class CategoriasRecetas extends Model
{
    use HasFactory;


    public function recetas()
    {
        return $this->hasMany(Recetas::class, 'categorias_recetas_id');
    }
}
