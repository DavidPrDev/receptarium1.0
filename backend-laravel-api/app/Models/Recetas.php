<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
