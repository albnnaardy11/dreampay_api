<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
