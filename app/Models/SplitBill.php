<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="SplitBill",
 *     title="Split Bill",
 *     description="Split Bill model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="owner_id", type="integer", example=1),
 *     @OA\Property(property="total_amount", type="number", example=60000),
 *     @OA\Property(property="description", type="string", example="Dinner split"),
 *     @OA\Property(property="status", type="string", example="pending")
 * )
 */
class SplitBill extends Model
{
    use HasFactory;

    protected $fillable = ['owner_id', 'total_amount', 'description', 'status'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->hasMany(SplitBillMember::class);
    }
}
