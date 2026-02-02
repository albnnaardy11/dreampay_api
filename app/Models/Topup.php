<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Topup",
 *     title="Topup",
 *     description="Topup model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="amount", type="number", example=50000),
 *     @OA\Property(property="created_at", type="string", format="date-time")
 * )
 */
class Topup extends Model
{
    protected $fillable = ['user_id', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
