<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Receptarium  API",
 *     version="1.0.0",
 *    
 *      @OA\Contact(
 *         email="contacto@david-pr.com",
 *         name="David Pérez Romero"
 *     ),
 *     @OA\License(
 *         name="Licencia",
 *         url="http://www.example.com"
 *     )
 * )
 * @OA\SecurityScheme(
 *    securityScheme="bearerAuth",
 *    in="header",
 *    name="Authorization",
 *    type="http",
 *    scheme="bearer",
 *    bearerFormat="JWT",
 * )
 */

abstract class Controller
{
}
