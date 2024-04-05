<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasRecetas extends Model
{
    use HasFactory;


    public function recetas()
    {
        return $this->hasMany(Recetas::class, 'categorias_recetas_id');
    }
}
