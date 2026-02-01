<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'pin', 
        'balance', 
        'points', 
        'tier', 
        'qr_code'
    ];

    protected $hidden = [
        'password',
        'pin',
    ];

    /**
     * Hash PIN automatically when set
     */
    public function setPinAttribute($value)
    {
        if ($value) {
            $this->attributes['pin'] = \Illuminate\Support\Facades\Hash::make($value);
        }
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'merchant_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function merchantOrders()
    {
        return $this->hasMany(Order::class, 'merchant_id');
    }



    public function topups()
    {
        return $this->hasMany(Topup::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }



}
