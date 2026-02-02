<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="SplitBillMember",
 *     title="Split Bill Member",
 *     description="Split Bill Member model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="split_bill_id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=2),
 *     @OA\Property(property="amount", type="number", example=20000),
 *     @OA\Property(property="status", type="string", example="pending")
 * )
 */
class SplitBillMember extends Model
{
    use HasFactory;

    protected $fillable = ['split_bill_id', 'user_id', 'amount', 'status'];

    public function splitBill()
    {
        return $this->belongsTo(SplitBill::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
