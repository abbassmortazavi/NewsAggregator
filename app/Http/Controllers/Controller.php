<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Api Documentation", version="0.1")
 * @OA\SecurityScheme(
 *        securityScheme="bearerAuth",
 *        type="http",
 *        scheme="bearer",
 *        bearerFormat="plain"
 *    )
 */
abstract class Controller
{
    //
}
