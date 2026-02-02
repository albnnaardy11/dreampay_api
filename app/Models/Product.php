<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Product",
 *     title="Product",
 *     description="Product model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="merchant_id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Nasi Goreng"),
 *     @OA\Property(property="description", type="string", example="Nasi goreng pedas sedap"),
 *     @OA\Property(property="price", type="number", example=15000),
 *     @OA\Property(property="stock", type="integer", example=50)
 * )
 */
class Product extends Model
{
    use HasFactory;
}
