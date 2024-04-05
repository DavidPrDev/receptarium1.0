<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasosRecetaController;
use App\Http\Controllers\RecetaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::resource('/receta', RecetaController::class);

    Route::resource('/pasos', PasosRecetaController::class);

    Route::get('/recetas-categoria/{id}', [RecetaController::class, 'recetasEnCategoria']);
});
