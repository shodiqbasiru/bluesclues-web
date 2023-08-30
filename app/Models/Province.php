<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',

    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'province_id', 'province_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'province_id', 'province_id');
    }
}
