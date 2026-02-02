<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Order",
 *     title="Order",
 *     description="Order model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="merchant_id", type="integer", example=1),
 *     @OA\Property(property="total_price", type="number", example=45000),
 *     @OA\Property(property="status", type="string", example="pending")
 * )
 */
class Order extends Model
{
    use HasFactory;
}
