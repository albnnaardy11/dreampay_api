<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Transaction",
 *     title="Transaction",
 *     description="Transaction model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="amount", type="number", format="float", example=15000),
 *     @OA\Property(property="description", type="string", example="Beli Nasi Goreng"),
 *     @OA\Property(property="type", type="string", example="payment"),
 *     @OA\Property(property="status", type="string", example="success"),
 *     @OA\Property(property="recipient_id", type="integer", nullable=true, example=null),
 *     @OA\Property(property="category_id", type="integer", example=2),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Transaction extends Model
{
    protected $fillable = [
        'user_id', 
        'description', 
        'amount', 
        'type', 
        'status', 
        'recipient_id', 
        'category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    use HasFactory;
}
