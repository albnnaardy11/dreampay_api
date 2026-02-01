<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
