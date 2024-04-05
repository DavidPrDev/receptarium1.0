<?php

namespace App\Policies;

use App\Models\PasosRecetas;
use App\Models\Recetas;
use App\Models\User;

class RecetaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function validateUser(User $user, Recetas $receta): bool
    {
        return $user->id === $receta->user_id;
    }

    /*   public function validateUserPaso(Recetas $receta, PasosRecetas $pasos): bool
    {
        return $user->id === $receta->user_id;
    }  */
}
