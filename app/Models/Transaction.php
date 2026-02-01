<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
