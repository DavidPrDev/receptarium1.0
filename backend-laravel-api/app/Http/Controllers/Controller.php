<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Nombre de tu API",
 *     version="1.0.0",
 *     description="Descripción de tu API",
 *     @OA\Contact(
 *         email="tu@email.com",
 *         name="Tu Nombre"
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
