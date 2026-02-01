<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="DreamPay API",
 *     version="1.0.0",
 *     description="High-integrity financial API for Santri Market Day ecosystem. Built with Laravel and secured with Sanctum.",
 *     @OA\Contact(
 *         email="admin@dreampay.id",
 *         name="DreamPay Team"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost/api",
 *     description="Local Development Server"
 * )
 * 
 * @OA\Server(
 *     url="https://api.dreampay.id/api",
 *     description="Production Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter your Bearer token in the format: Bearer {token}"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
