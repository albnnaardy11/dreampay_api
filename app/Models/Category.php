<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Category",
 *     title="Category",
 *     description="Category model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Food"),
 *     @OA\Property(property="icon", type="string", example="utensils")
 * )
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
