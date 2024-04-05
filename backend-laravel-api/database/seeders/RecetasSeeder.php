<?php

namespace Database\Seeders;

use App\Models\PasosRecetas;
use App\Models\Recetas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recetas::create([
            "titulo" => "Receta 1",
            "Ingredientes" => "ingrediente 1, ingrediente 2, ingrediente 3",
            "num_personas" => 2,
            "tiempo_preparacion" => "45 m",
            "descripcion" => "Descripcion de la receta 1",
            "ruta_imagen_principal" => "/img/test.jpg",
            "user_id" => 1,
            "categorias_recetas_id" => 1
        ]);

        PasosRecetas::create([
            "titulo" => "Paso 1",
            "descripcion" => "Descripcion paso 1",
            "ruta_imagen" => "/img/paso1.jpg",
            "recetas_id" => 1
        ]);

        PasosRecetas::create([
            "titulo" => "Paso 2",
            "descripcion" => "Descripcion paso 2",
            "ruta_imagen" => "/img/paso2.jpg",
            "recetas_id" => 1
        ]);
    }
}
