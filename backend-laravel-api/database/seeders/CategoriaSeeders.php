<?php

namespace Database\Seeders;

use App\Models\CategoriasRecetas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoriasRecetas::create([
            'nombre' => 'Entrantes'
        ]);
        CategoriasRecetas::create([
            'nombre' => 'Platos principales'
        ]);
        CategoriasRecetas::create([
            'nombre' => 'Guarniciones'
        ]);
        CategoriasRecetas::create([
            'nombre' => 'Postres'
        ]);
    }
}
