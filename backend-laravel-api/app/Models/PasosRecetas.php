<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasosRecetas extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'ruta_imagen',
        'recetas_id'
    ];

    public function receta()
    {
        return $this->belongsTo(Recetas::class);
    }
}
