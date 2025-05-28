<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email', ];



    public function topups()
    {
        return $this->hasMany(Topup::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    use HasFactory;
}
